<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Game;

class GameController extends Controller
{
    public function index() {
        return view('games.index', ['games' => Game::all()]);
    }
}
