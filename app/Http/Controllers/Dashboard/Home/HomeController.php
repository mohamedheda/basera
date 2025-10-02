<?php

namespace App\Http\Controllers\Dashboard\Home;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard.site.home.index');
    }
}
