<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'metadata'];

    protected $casts = [
        'metadata' => 'object',
        'platform_slugs' => 'array'
    ];

    public function getCoverUrl() {
        return 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$this->cover_image_id.'.jpg';
    }
}
