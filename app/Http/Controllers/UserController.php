<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userRegistration(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'mobile'     => ['required', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/'], // Supports 013-019 and optional +88
            'email'      => ['required', 'regex:/^\S+@\S+\.\S+$/'], // Basic email format
            'password'   => ['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'], //Minimum eight characters, at least one letter, one number and one special character:
        ]);



        try {
            $user                   = new User();
            $user->first_name       = $request->input('first_name');
            $user->last_name        = $request->input('last_name');
            $user->mobile           = $request->input('mobile');
            $user->email            = $request->input('email');
            $user->password         = $request->input('password');
            $user->password         = $request->input('password');
            $user->save();

            return response()->json([
                'status' => 'success',
                'message'=> 'User Registraation Successfully'
            ], 200);
        }
        catch(Exception $e)
        {

            return response()->json([
                'status' => 'faild',
                'message'=> $e->getMessage()
            ], 400);
        }

    }
}
