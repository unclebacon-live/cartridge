<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Platform;
use App\Models\File;

class PlatformController extends Controller
{
    public function index() {
        $platforms = Platform::whereIn('id', File::distinct()->select('platform_id')->get())->get();
        return view('platforms.index', ['platforms' => $platforms]);
    }

    public function show($slug) {
        $platform = Platform::where('slug', $slug)->first();
        return view('platforms.show', ['games' => $platform->getGames(), 'platform' => $platform]);
    }
}