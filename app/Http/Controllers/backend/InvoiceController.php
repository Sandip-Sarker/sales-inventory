<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class InvoiceController extends Controller
{
    public function SalePage()
    {
        return view('backend.home.sale-page');
    }
}


