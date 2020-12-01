<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
