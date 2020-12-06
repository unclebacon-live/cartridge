<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\Game;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'metadata'];
    
    protected $casts = [
        'metadata' => 'object'
    ];

    public function getLogoUrl() {
        return asset('storage/logos/'.$this->slug.'.png');
    }

    public function getGamesAttribute() {
        return Game::whereFileExists()->whereJsonContains('platform_slugs', $this->slug)->get();
    }

    public static function whereFileExists() {
        return Platform::whereIn('id', File::distinct()->select('platform_id')->get());
    }
}
