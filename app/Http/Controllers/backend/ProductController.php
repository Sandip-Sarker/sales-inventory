<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('backend.home.product-page');
    }

    public function getData(Request $request)
    {
        $user_id = $request->header('id');
        return Product::where('user_id', '=', $user_id)->get();
    }

    public function create(Request $request)
    {
        $user_id = $request->header('id');

        // Prepare File Name & Path
        $image          = $request->file('image');

        $currentTime    = time();
        $fileName       = $image->getClientOriginalName();
        $imageName      = "{$user_id}-{$currentTime}-{$fileName}";
        $imageUrl       = "uploads/product-image/{$imageName}";

        // Upload File
        $image->move(public_path('uploads/product-image'),$imageName);

        $data               = new Product();
        $data->user_id      = $user_id;
        $data->name         = $request->input('name');
        $data->price        = $request->input('price');
        $data->unit         = $request->input('unit');
        $data->description  = $request->input('description');
        $data->category_id  = $request->input('category_id');
        $data->image        = $imageUrl;
        return $data->save();
    }

//    public function edit(Request $request)
//    {
//        $customer_id    = $request->input('id');
//        $user_id        = $request->header('id');
//
//        return Customer::where('id',$customer_id)
//            ->where('user_id', $user_id)
//            ->first();
//    }
//
//    public function update(Request $request)
//    {
//        $customer_id    = $request->input('id');
//        $user_id        = $request->header('id');
//
//        return Customer::where('id',$customer_id)
//            ->where('user_id', $user_id)
//            ->update([
//                'name'      => $request->input('name'),
//                'email'     => $request->input('email'),
//                'mobile'    => $request->input('mobile'),
//                'address'   => $request->input('address'),
//            ]);
//    }
//
//
    public function delete(Request $request)
    {
        $user_id       = $request->header('id');
        $product_id    = $request->input('id');
        $file_path     = $request->input('file_path');
        File::delete($file_path);

        return Product::where('id',$product_id)
            ->where('user_id', $user_id)
            ->delete();
    }
}
