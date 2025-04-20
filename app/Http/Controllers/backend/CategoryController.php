<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class CategoryController extends Controller
{
    public function index()
    {
        return view('backend.home.category-page');
    }
}
