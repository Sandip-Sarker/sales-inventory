<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Category;
use Exception;
use Illuminate\Http\Request;
use function response;
use function view;

class CategoryController extends Controller
{
    public function index()
    {
        return view('backend.home.category-page');
    }

    public function getData(Request $request)
    {
        $user_id = $request->header('id');
        return Category::where('user_id', '=', $user_id)->get();
    }

    public function create(Request $request)
    {
        try {
            $data = new Category();
            $data->user_id   = $request->header('id');
            $data->name      = $request->input('name');
            $data->save();

            return response()->json([
                'status' => 'success',
                'message'=> 'Category Create Successfully'
            ], 200);
        }catch (Exception $e){

            return response()->json([
                'status' => 'failed',
                'message'=> $e->getMessage()
            ]);
        }

    }
}
