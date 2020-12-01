<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Builder as IGDB;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Platform;
use RecursiveDirectoryIterator;
use RecursiveTreeIterator;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Illuminate\Support\Facades\Storage;

class ScanGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playdarr:scan';

    protected $game_files = [];
    protected $platforms = [];

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
        echo sprintf($msg_format, ...$args) . "\n";
    }

    private function scan_directory($dir) {
        $dir = realpath($dir); // remove trailing slash

        if(is_dir($dir)) {
            foreach(scandir($dir) as $target) {
                if($target != '.' && $target != '..') {
                    $path = $dir . '/' . $target;

                    if(is_dir($path)) {
                        $this->scan_directory($path);
                    } else if(is_file($path)) {
                        $pathinfo = pathinfo($path);
        
                        if(in_array($pathinfo['extension'], config('playdarr.allowed_file_types'))) {
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

        $logo_image_id = \MarcReichel\IGDBLaravel\Models\PlatformLogo::where('id', '=', $data->platform_logo)->first()->image_id;
        $this->save_image('https://images.igdb.com/igdb/image/upload/t_logo_med/'.$logo_image_id.'.png', 'public/logos/'.$platform->slug);
        return $platform;
    }

    private function cache_game($data) {
        $game = \App\Models\Game::firstOrNew(['slug' => $data->slug]);
        $game->metadata = json_decode($data->toJson());
        $game->name = $data->name;
        $game->cover_image_id = \MarcReichel\IGDBLaravel\Models\Cover::where('id', '=', $game->metadata->cover)->first()->image_id;
        $game->save();

        $this->cache_game_images($game);

        return $game;
    }

    private function cache_game_images($game) {
        $this->save_image('https://images.igdb.com/igdb/image/upload/t_cover_big/'.$game->cover_image_id.'.jpg', 'public/covers/'.$game->slug);
        $this->save_image('https://images.igdb.com/igdb/image/upload/t_screenshot_big/'.$game->cover_image_id.'.jpg', 'public/backgrounds/'.$game->slug);
    }

    private function save_image($url, $filename) {
        $pathinfo = pathinfo($url);
        $contents = file_get_contents($url);
        Storage::put($filename.'.'.$pathinfo['extension'], $contents);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $igdb = new IGDB('games');

        $this->scan_directory(env('GAMES_PATH')); // find games at game path

        \App\Models\File::truncate();

        foreach($this->game_files as $path) {
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

            if(array_key_exists($ext, config('playdarr.extension_to_platform_slug'))) {
                $slug = config('playdarr.extension_to_platform_slug')[$ext];

                $platform_data = Platform::where('slug', '=', $slug)->first();
                $platform = $this->cache_platform($platform_data);

                $this->log('Identified platform: %s', $platform->name);
        
                $games = $games->where('release_dates.platform', $platform->metadata->id);

                usleep(ScanGames::API_SLEEP_TIME);
            }

            $games = $games->search($filename);
            $game_data = $games->first();

            if($game_data != null) {
                $this->log('Matched with %s', $game_data->name);
                $game = $this->cache_game($game_data);

                $file = new \App\Models\File();
                $file->platform_id = $platform->id;
                $file->game_id = $game->id;
                $file->path = str_replace(env('GAMES_PATH'), '', $path);
                $file->save();
            }

            usleep(ScanGames::API_SLEEP_TIME);
        }

        return 0;
    }
}
