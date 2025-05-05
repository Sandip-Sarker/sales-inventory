<?php

use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\InvoiceController;


Route::get('/', function () {
    return view('welcome');
});

// Web Api Routes
Route::post('/user-registrations', [UserController::class, 'userRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user.login');
Route::post('/send-otp-email', [UserController::class, 'sendOtpEmail'])->name('send.otp.email');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/password-reset', [UserController::class, 'resetPassword'])->name('password.reset')->middleware([TokenVerificationMiddleware::class]);


// Page Routes
Route::get('/login',[UserController::class,'LoginPage'])->name('login');
Route::get('/registration',[UserController::class,'RegistrationPage'])->name('registration');
Route::get('/sendOtp',[UserController::class,'SendOtpPage'])->name('send.otp');
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage'])->name('verify')->middleware([TokenVerificationMiddleware::class]);
Route::get('/forgot-password',[UserController::class,'ResetPasswordPage'])->name('forgot.password')->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout',[UserController::class,'userLogout'])->name('logout');



Route::middleware([TokenVerificationMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/userProfile',[DashboardController::class,'userProfile'])->name('user.profile');
    Route::get('/summary',[DashboardController::class,'summary'])->name('summary');

    // Profile
    Route::get('/profile-details', [UserController::class, 'userProfileDataGet'])->name('user.profile.detail');
    Route::post('/profile-update', [UserController::class, 'userProfileUpdate'])->name('user.profile.update');

    // Category
    Route::get('/category-index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category-list', [CategoryController::class, 'getData'])->name('category.list');
    Route::post('/category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category-edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category-update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category-delete', [CategoryController::class, 'delete'])->name('category.delete');

    // Customer
    Route::get('/customer-index',[CustomerController::class,'index'])->name('customer.index');
    Route::get('/customer-list',[CustomerController::class,'getData'])->name('customer.list');
    Route::post('/customer-create',[CustomerController::class,'create'])->name('customer.create');
    Route::post('/customer-edit',[CustomerController::class,'edit'])->name('customer.edit');
    Route::post('/customer-update',[CustomerController::class,'update'])->name('customer.update');
    Route::post('/customer-delete',[CustomerController::class,'delete'])->name('customer.delete');

    // Product
    Route::get('/product-index',[ProductController::class,'index'])->name('product.index');
    Route::get('/product-list',[ProductController::class,'getData'])->name('product.list');
    Route::post('/product-create',[ProductController::class,'create'])->name('product.create');
    Route::post('/product-edit',[ProductController::class,'edit'])->name('product.edit');
    Route::post('/product-update',[ProductController::class,'update'])->name('product.update');
    Route::post('/product-delete',[ProductController::class,'delete'])->name('product.delete');

    // Invoice
    Route::get('/salePage',[InvoiceController::class,'SalePage'])->name('sale.create');
    Route::post("/invoice-create",[InvoiceController::class,'invoiceCreate'])->name('invoice.create');
    Route::get("/invoice-page",[InvoiceController::class,'invoicePage'])->name('invoice.page');
    Route::get("/invoice-list",[InvoiceController::class,'invoiceList'])->name('invoice.list');
    Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails'])->name('invoice.details');
    Route::post("/invoice-delete",[InvoiceController::class,'invoiceDelete'])->name('invoice.delete');


});


