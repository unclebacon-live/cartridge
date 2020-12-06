<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function game() {
        return $this->belongsTo('App\Models\Game');
    }

    public function platform() {
        return $this->belongsTo('App\Models\Platform');
    }

    public function getDownloadUrlAttribute() {
        $pathinfo = pathinfo($this->path);
        return route('download', [
            'id' => $this->id, 
            'filename' => $this->game->slug . '.' . $pathinfo['extension']
        ]);
    }

    public function getPathExistsAttribute() {
        return Storage::disk('games')->exists($this->path);
    }
}
