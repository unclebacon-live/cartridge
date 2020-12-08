<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    function index() {
        return view('admin.users.index');
    }
}
