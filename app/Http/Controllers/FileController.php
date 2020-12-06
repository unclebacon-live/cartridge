<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    function download($file_id, $filename) {
        $file = File::where('id', $file_id)->first();
        
        $game = $file->game;
        $game->download_count++;
        $game->save();

        return Storage::disk('games')->download($file->path, $filename);
    }
}
