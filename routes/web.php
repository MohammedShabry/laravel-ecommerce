<?php


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;


// Root route: show single login form as the initial page
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Single login form for all roles (admin, seller, customer)
Route::get('/login', [AuthenticatedSessionController::class,'create'])->name('login.form');
Route::post('/login', [AuthenticatedSessionController::class,'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class,'destroy'])->name('logout');

// Registration: choice page, then separate pages for seller/customer. The POST /register route
// is the shared registration handler used by both forms.
Route::get('/register', [RegisteredUserController::class,'create'])->name('register.choice');
Route::get('/register/seller', [RegisteredUserController::class,'createSeller'])->name('register.seller');
Route::get('/register/customer', [RegisteredUserController::class,'createCustomer'])->name('register.customer');
Route::post('/register', [RegisteredUserController::class,'store'])->name('register');

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminDashboardController::class,'dashboard'])->name('admin.dashboard');
});
Route::middleware(['auth','role:seller'])->group(function(){
    Route::get('/seller/dashboard',[SellerDashboardController::class,'dashboard'])->name('seller.dashboard');
    // POST route kept for form submission from the dashboard modal
    Route::post('/seller/kyc',[SellerDashboardController::class,'submitKyc'])->name('seller.kyc.submit');
});
Route::middleware(['auth','role:customer'])->group(function(){
    Route::get('/customer/dashboard',[CustomerDashboardController::class,'dashboard'])->name('customer.dashboard');
    Route::view('/customer/home', 'customer.home')->name('customer.home');
    Route::view('/customer/about', 'customer.about')->name('customer.about');
    Route::view('/customer/contact', 'customer.contact')->name('customer.contact');
    Route::view('/customer/cart', 'customer.cart')->name('customer.cart');
    Route::view('/customer/wishlist', 'customer.wishlist')->name('customer.wishlist');
    Route::view('/customer/shopgrid', 'customer.shopgrid')->name('customer.shopgrid');
    Route::view('/customer/productdetails', 'customer.productdetails')->name('customer.productdetails');
    Route::view('/customer/myaccount', 'customer.myaccount')->name('customer.myaccount');
    Route::view('/customer/privacyandpolicy', 'customer.privacypolicy')->name('customer.privacyandpolicy');
    Route::view('/customer/vendors', 'customer.vendors')->name('customer.vendors');
    Route::view('/customer/vendorproducts', 'customer.vendorproducts')->name('customer.vendorproducts');
    Route::view('/customer/checkout', 'customer.checkout')->name('customer.checkout');
    Route::view('/customer/allproducts', 'customer.allproducts')->name('customer.allproducts');
});
