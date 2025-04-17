<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// User Controller
Route::post('/user-registrations', [UserController::class, 'userRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user.login');


//Send OTP Email
Route::post('/send-otp-email', [UserController::class, 'sendOtpEmail'])->name('send.otp.email');

// Verify OTP
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');
