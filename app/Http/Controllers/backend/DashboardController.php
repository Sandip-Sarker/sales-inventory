<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.home.dashboard');
    }

    public function userProfile()
    {
        return view('backend.home.profile');
    }

}
