<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\Storage;

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

    public function getCoverUrl() {
        return asset('storage/covers/'.$this->slug.'.jpg');
    }

    public function getBackgroundUrl() {
        return asset('storage/backgrounds/'.$this->slug.'.jpg');
    }

    public function files() {
        return $this->hasMany('App\Models\File');
    }

    public function getPlatforms() {
        $platforms = [];

        foreach($this->platform_slugs as $slug) {
            $platform = Platform::where('slug', $slug)->first();

            if($platform != null) {
                array_push($platforms, $platform);
            }
        }
        
        return $platforms;
    }
}
