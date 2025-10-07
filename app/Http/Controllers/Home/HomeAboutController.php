<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeAboutController extends Controller
{
    public function __invoke()
    {
        return view('about');
    }
}
