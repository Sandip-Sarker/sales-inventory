<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Helper\JWTToken;
use Illuminate\Support\Facades\Mail;
use function response;
use function view;

class UserController extends Controller
{

    public function LoginPage()
    {
        return view('frontend.auth.login');
    }

    public function RegistrationPage()
    {
        return view('frontend.auth.registration');
    }

    public function SendOtpPage()
    {
        return view('frontend.auth.send-otp');
    }

    public function VerifyOTPPage()
    {
        return view('frontend.auth.verify-otp');
    }

    public function ResetPasswordPage()
    {
        return view('frontend.auth.forgot-password');
    }

    public function userRegistration(Request $request)
    {
//        $validated = $request->validate([
//            'first_name' => 'required',
//            'last_name'  => 'required',
//            'mobile'     => ['required', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/'], // Supports 013-019 and optional +88
//            'email'      => ['required', 'regex:/^\S+@\S+\.\S+$/'], // Basic email format
//            'password'   => ['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'], //Minimum eight characters, at least one letter, one number and one special character:
//        ]);


        try {
            $user                   = new User();
            $user->first_name       = $request->input('first_name');
            $user->last_name        = $request->input('last_name');
            $user->mobile           = $request->input('mobile');
            $user->email            = $request->input('email');
            $user->password         = $request->input('password');
            $user->save();

            return response()->json([
                'status' => 'success',
                'message'=> 'User Registration Successfully'
            ], 200);
        }
        catch(Exception $e)
        {

            return response()->json([
                'status' => 'failed',
                'message'=> $e->getMessage()
            ]);
        }

    }

    public function userLogin(Request $request)
    {
        $userCount = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();

        if ($userCount !== null)
        {
            $token = JWTToken::createToken($request->input('email'), $userCount->id);
            return response()->json([
                'status' => 'success',
                'message'=> 'User Login Successfully',
            ], 200)->cookie('token', $token, 60*24*30);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Unauthorized'
            ]);
        }
    }

    public function sendOtpEmail(Request $request)
    {
        $email  = $request->input('email');
//        $otp    = rand(1000, 9999); //rand otp
        $otp    = 1234;  // Defult otp

        $count = User::where('email', '=', $email)->count();

        if ($count == 1)
        {
            // OTP email address
            Mail::to($email)->send(new OTPMail($otp));

            //OTP code table insert
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message'=> 'Your OTP Code is 1234'
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Unauthorized'
            ]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $email = $request->input('email');
        $otp    = $request->input('otp');

        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();

        if ($count == 1)
        {
            //Database OTP update
            User::where('email', '=', $email)->update(['otp' => '0']);

            //Pass reset token issue
            $token = JWTToken::createTokenForSetPassowrd($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message'=> 'OTP Verification Successfully',

            ], 200)->cookie('token', $token,60*24*30);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Unauthorized'
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $email      = $request->header('email');
            $password   = $request->input('password');

            User::where('email', '=', $email)
                ->update([
                    'password' => $password
                ]);

            return response()->json([
                'status' => 'success',
                'message'=> 'Password Reset Successfully'
            ], 200);
        }
        catch (Exception $e)
        {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Something Went Wrong'
            ], 400);
        }
    }

    public function userLogout()
    {
        return redirect('/login')->cookie('token', '', -1);
    }

    public function userProfileDataGet(Request $request)
    {
        $email  = $request->header('email');
        $user   = User::where('email', '=', $email)->first();

        return response()->json([
           'status'     => 'success',
            'message'   => 'Request Successfully',
            'data'      => $user
        ], 200);
    }

    public function userProfileUpdate(Request $request)
    {
        try {
            $email      = $request->header('email');
            $first_name = $request->input('first_name');
            $last_name  = $request->input('last_name');
            $mobile     = $request->input('mobile');
            $password   = $request->input('password');

            $user       = User::where('email', '=', $email)->update([
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'mobile'        => $mobile,
                'password'      => $password,
            ]);

            return response()->json([
                'status'        => 'success',
                'message'       => 'Request Successfully',
                'data'          => $user
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'     => 'fail',
                'message'    => 'Something Went Wrong',
            ]);
        }

    }

}
