<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\Storage;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'metadata'];

    protected $casts = [
        'metadata' => 'object',
        'platform_slugs' => 'array'
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
}
