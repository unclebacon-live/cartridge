<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class LibraryController extends Controller
{
    function update() {
        Artisan::call('cartridge:scan');
    }

    function refresh() {
        Artisan::call('cartridge:scan', ['--refresh' => true]);
    }
}
