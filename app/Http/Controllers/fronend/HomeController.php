<?php

namespace App\Http\Controllers\fronend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home.index');
    }
}
