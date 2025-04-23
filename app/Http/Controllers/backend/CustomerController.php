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

    public function getData(Request $request)
    {
        $user_id = $request->header('id');
        return Customer::where('user_id', '=', $user_id)->get();
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

    public function edit(Request $request)
    {
        $customer_id    = $request->input('id');
        $user_id        = $request->header('id');

        return Customer::where('id',$customer_id)
            ->where('user_id', $user_id)
            ->first();
    }


    public function delete(Request $request)
    {
        $customer_id    = $request->input('id');
        $user_id        = $request->header('id');

        return Customer::where('id',$customer_id)
            ->where('user_id', $user_id)
            ->delete();
    }
}
