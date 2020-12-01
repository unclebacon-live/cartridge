<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function game() {
        return $this->belongsTo('App\Models\Game');
    }

    public function platform() {
        return $this->belongsTo('App\Models\Platform');
    }

    public function getDownloadUrl() {
        $pathinfo = pathinfo($this->path);
        return route('download', [
            'id' => $this->id, 
            'filename' => $this->game->slug . '.' . $pathinfo['extension']
        ]);
    }
}
