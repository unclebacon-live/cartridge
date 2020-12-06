<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\Storage;
use \App\Enums\WebsiteCategory;

use \App\Models\Platform;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'metadata'];

    protected $casts = [
        'metadata' => 'object',
        'platform_slugs' => 'array',
        'links' => 'array'
    ];

    public function getLinkListAttribute() {
        $links = [];

        foreach($this->links as $link) {
            array_push($links, [
                'category' => WebsiteCategory::coerce($link['category'])->key,
                'url' => $link['url']
            ]);
        }

        return $links;
    }

    public function getCoverPathAttribute() {
        return asset('storage/covers/'.$this->slug.'.png');
    }

    public function getBackgroundPathAttribute() {
        return asset('storage/backgrounds/'.$this->slug.'.png');
    }

    public function files() {
        return $this->hasMany('App\Models\File');
    }
    
    public function getDescriptionAttribute() {
        $description = "";

        if($this->metadata->summary) {
            $description = $this->metadata->summary;
        } else if($this->metadata->storyline) {
            $description = $this->metadata->storyline;
        }

        return nl2br(htmlentities($description));
    }

    public function getPlatformsAttribute() {
        $platforms = [];

        foreach($this->platform_slugs as $slug) {
            $platform = Platform::where('slug', $slug)->first();

            if($platform != null) {
                array_push($platforms, $platform);
            }
        }
        
        return $platforms;
    }

    public static function whereFileExists() {
        return Game::whereIn('id', File::distinct()->select('game_id')->get());
    }
}
