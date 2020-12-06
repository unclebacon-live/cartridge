<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Builder as IGDB;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Platform;
use MarcReichel\IGDBLaravel\Models\Website;
use RecursiveDirectoryIterator;
use RecursiveTreeIterator;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

use Illuminate\Support\Facades\Log;

use App\Enums\WebsiteCategory;

class ScanGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cartridge:scan';

    protected $game_files = [];
    protected $identified_platforms = [];

    const API_SLEEP_TIME = 250000;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan games folder and update database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function log($msg_format, ...$args) {
        $message = sprintf($msg_format, ...$args);
        echo sprintf($msg_format, ...$args) . "\n";
    }

    private function scan_directory($dir) {
        $dir = realpath($dir); // Resolve path

        if(is_dir($dir)) {
            foreach(scandir($dir) as $target) {
                if($target != '.' && $target != '..') {
                    $path = $dir . '/' . $target;

                    if(is_dir($path)) {
                        $this->scan_directory($path);
                    } else if(is_file($path)) {
                        $pathinfo = pathinfo($path);
        
                        if(array_key_exists($pathinfo['extension'], config('cartridge.file_extension_slugs'))) {
                            array_push($this->game_files, $path);
                            $this->log('Found %s', $path);
                        }
                    }
                }
            }
        } else {
            throw new DirectoryNotFoundException($dir . ' is not a directory');
        }
    }

    private function cache_platform($data) {
        $platform = \App\Models\Platform::firstOrNew(['slug' => $data->slug]);
        $platform->metadata = json_decode($data->toJson());
        $platform->name = $data->name;
        $platform->save();

        $logo = \MarcReichel\IGDBLaravel\Models\PlatformLogo::where('id', '=', $data->platform_logo)->first();
        if($logo != null) {
            $this->save_image($logo->image_id, 'cover_big', 'public/platforms/'.$platform->slug);
        }

        return $platform;
    }

    private function cache_game($data) {
        $game = \App\Models\Game::firstOrNew(['slug' => $data->slug]);
        $game->metadata = json_decode($data->toJson());
        $game->name = $data->name;
        $game->cover_image_id = \MarcReichel\IGDBLaravel\Models\Cover::where('id', '=', $game->metadata->cover)->first()->image_id;
        $game->platform_slugs = $this->get_game_platform_slugs($data);
        $game->links = $this->get_game_links($data);
        $game->save();

        $cover = \MarcReichel\IGDBLaravel\Models\Cover::where('id', '=', $game->metadata->cover)->first();
        if($cover != null) {
            $this->save_image($cover->image_id, "cover_big", 'public/covers/'.$game->slug);
        }

        $screenshot = \MarcReichel\IGDBLaravel\Models\Screenshot::where('game', '=', $game->metadata->id)->first();
        if($screenshot != null) {
            $this->save_image($screenshot->image_id, "screenshot_big", 'public/backgrounds/'.$game->slug);
        }

        return $game;
    }

    private function get_game_platform_slugs($game_data) {
        $platform_slugs = [];

        foreach($game_data->platforms as $platform_id) {
            $platform_data = Platform::where('id', '=', $platform_id)->first();
            $platform = $this->cache_platform($platform_data);
            array_push($platform_slugs, $platform->slug);
            usleep(ScanGames::API_SLEEP_TIME);
        }

        return $platform_slugs;
    }

    private function get_game_links($game_data) {
        $links = [];

        if($game_data->websites) {
            foreach($game_data->websites as $website_id) {
                $website = Website::where('id', '=', $website_id)->first();
                array_push($links, [
                    'category' => WebsiteCategory::fromValue($website->category),
                    'url' => $website->url
                ]);
                usleep(ScanGames::API_SLEEP_TIME);
            }
        }

        return $links;
    }

    private function cache_file($path, $platform, $game) {
        if(\App\Models\File::where(['platform_id' => $platform->id, 'game_id' => $game->id])->exists()) {
            $this->log('Duplicate file for %s found at %s', $game->name, $path);
            Log::warning("Duplicate file for {$game->name} found at $path");
        } else {
            $file = new \App\Models\File();
            $file->path = $path;
            $file->platform_id = $platform->id;
            $file->game_id = $game->id;
            $file->save();
        }
    }

    private function save_image($image_id, $size, $filename) {
        $url = "https://images.igdb.com/igdb/image/upload/t_$size/$image_id.png";

        $pathinfo = pathinfo($url);

        $contents = @file_get_contents($url);

        if($contents) {
            Storage::put($filename.'.'.$pathinfo['extension'], $contents);
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Starting game scan.');
        $igdb = new IGDB('games');

        // \App\Models\File::truncate(); // Clear files from DB
        $this->scan_directory(env('GAMES_PATH')); // Find game files

        foreach($this->game_files as $path) {
            $relative_path = str_replace(realpath(env('GAMES_PATH')).'/', '', $path);

            if(File::where('path', $relative_path)) {
                continue;
            }

            $pathinfo = pathinfo($path);

            $file = $pathinfo['basename'];
            $ext = $pathinfo['extension'];
            $filename = $pathinfo['filename'];

            $this->log('Matching %s...', $file);

            // Models
            $platform = null;
            $game = null;

            // Search
            $games = new Game();

            if(array_key_exists($ext, config('cartridge.file_extension_slugs'))) {
                $slug = config('cartridge.file_extension_slugs')[$ext];

                $platform = null;
                if(array_key_exists($slug, $this->identified_platforms)) {
                    $platform = $this->identified_platforms[$slug];
                    $this->log('Identified platform: %s', $platform->name);
                } else {
                    $platform_data = Platform::where('slug', '=', $slug)->first();
                    $platform = $this->cache_platform($platform_data);
                    $this->identified_platforms[$slug] = $platform;
                    usleep(ScanGames::API_SLEEP_TIME);
                    $this->log('Identified and cached platform: %s', $platform->name);
                }

        
                $games = $games->where('release_dates.platform', $platform->metadata->id);
            }

            $filename_clean = preg_replace("/(?:\(.+\))?\s*(?:\[.+\])?\.(?:.*)/", "", $filename.'.'.$ext);

            $games = $games->search($filename_clean);
            $game_data = $games->first();

            if($game_data != null) {
                $this->log('Matched with %s', $game_data->name);
                $game = $this->cache_game($game_data);
                $this->cache_file(str_replace(realpath(env('GAMES_PATH')).'/', '', $path), $platform, $game);
            }

            usleep(ScanGames::API_SLEEP_TIME);
        }

        return 0;
    }
}
