<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class HomeController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'recent' => Game::whereFileExists()->orderBy('created_at', 'desc')->limit(5)->get(),
            'popular' => Game::whereFileExists()->orderBy('download_count', 'desc')->limit(10)->get()
        ]);
    }
}
