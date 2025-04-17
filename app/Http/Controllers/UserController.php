<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Helper\JWTToken;
use Illuminate\Support\Facades\Mail;

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


    public function userLogin(Request $request)
    {
        $userCount = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();

        if ($userCount == 1)
        {
            $token = JWTToken::createToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message'=> 'Login Successfully',
                'token'  => $token
            ], 400);
        }
        else
        {
            return response()->json([
                'status' => 'faild',
                'message'=> 'Unauthorize'
            ], 400);
        }
    }

    public function sendOtpEmail(Request $request)
    {
        $email  = $request->input('email');
        $otp    = rand(1000, 9999);

        $count = User::where('email', '=', $email)->count();

        if ($count == 1)
        {
            // OTP email address
            Mail::to($email)->send(new OTPMail($otp));

            //OTP code table insert
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message'=> '4 Digit OTP Code has been send to your email !'
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'faild',
                'message'=> 'Unauthorize'
            ], 400);
        }
    }
}
