<?php

use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\backend\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

// Web Api Routes
Route::post('/user-registrations', [UserController::class, 'userRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user.login');
Route::post('/send-otp-email', [UserController::class, 'sendOtpEmail'])->name('send.otp.email');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/password-reset', [UserController::class, 'resetPassword'])->name('password.reset')->middleware([TokenVerificationMiddleware::class]);


Route::get('/profile-details', [UserController::class, 'userProfileDataGet'])->name('user.profile.detail')->middleware([TokenVerificationMiddleware::class]);
Route::post('/profile-update', [UserController::class, 'userProfileUpdate'])->name('user.profile.update')->middleware([TokenVerificationMiddleware::class]);


// user logout
Route::get('/logout',[UserController::class,'userLogout'])->name('logout');


// Page Routes
Route::get('/login',[UserController::class,'LoginPage'])->name('login');
Route::get('/registration',[UserController::class,'RegistrationPage'])->name('registration');
Route::get('/sendOtp',[UserController::class,'SendOtpPage'])->name('send.otp');
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage'])->name('verify')->middleware([TokenVerificationMiddleware::class]);
Route::get('/forgot-password',[UserController::class,'ResetPasswordPage'])->name('forgot.password')->middleware([TokenVerificationMiddleware::class]);

// Dashboard
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware([TokenVerificationMiddleware::class]);

// Profile
Route::get('/userProfile',[DashboardController::class,'userProfile'])->name('user.profile')->middleware([TokenVerificationMiddleware::class]);
