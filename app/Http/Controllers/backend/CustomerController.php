<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Customer;
use Illuminate\Http\Request;
use function view;

class CustomerController extends Controller
{
    public function index()
    {
        return view('backend.home.customer-page');
    }

    public function create(Request $request)
    {

       $data            = new Customer();
       $data->user_id   = $request->header('id');
       $data->name      = $request->input('name');
       $data->email     = $request->input('email');
       $data->mobile    = $request->input('mobile');
       $data->address   = $request->input('address');
       return $data->save();
    }
}
