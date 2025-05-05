<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Category;
use App\Models\backend\Customer;
use App\Models\backend\Product;
use App\Models\Invoice;
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

    function summary(Request $request):array{

        $user_id    =$request->header('id');

        $product    = Product::where('user_id',$user_id)->count();
        $Category   = Category::where('user_id',$user_id)->count();
        $Customer   = Customer::where('user_id',$user_id)->count();
        $Invoice    = Invoice::where('user_id',$user_id)->count();
        $total      = Invoice::where('user_id',$user_id)->sum('total');
        $vat        = Invoice::where('user_id',$user_id)->sum('vat');
        $payable    = Invoice::where('user_id',$user_id)->sum('payable');

        return[
            'product'   => $product,
            'category'  => $Category,
            'customer'  => $Customer,
            'invoice'   => $Invoice,
            'total'     => round($total,2),
            'vat'       => round($vat,2),
            'payable'   => round($payable,2)
        ];


    }
}
