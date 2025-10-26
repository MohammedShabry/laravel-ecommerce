<?php


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;


// Root route: show customer home/dashboard as the initial public page (no auth required)
// This allows visitors (authenticated or not) to see the customer-facing landing page
// and from there choose to register or log in.
Route::get('/', function () {
    return view('customer.home');
})->name('home');

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
    Route::view('/admin/productslist', 'admin.productslist')->name('admin.productslist');
    Route::get('/admin/attributes', [AttributeController::class, 'index'])->name('admin.attributes');
    // JSON data endpoint for AJAX refresh
    Route::get('/admin/attributes/data', [AttributeController::class, 'data'])->name('admin.attributes.data');
    Route::post('/admin/attributes', [AttributeController::class, 'store'])->name('admin.attributes.store');
    Route::put('/admin/attributes/{attribute}', [AttributeController::class, 'update'])->name('admin.attributes.update');
    Route::delete('/admin/attributes/{attribute}', [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');
    Route::resource('/admin/categories', App\Http\Controllers\Admin\CategoryController::class)->names([
        'index' => 'categories.index',
        'store' => 'categories.store',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ])->only(['index', 'store', 'update', 'destroy']);
    Route::view('/admin/orderlist', 'admin.orderlist')->name('admin.orderlist');
    Route::view('/admin/orderdetail', 'admin.orderdetail')->name('admin.orderdetail');
    Route::get('/admin/sellerlist', [\App\Http\Controllers\Admin\SellerController::class, 'index'])->name('admin.sellerlist');
    // show a specific seller detail page (admin)
    Route::get('/admin/sellers/{seller}', [\App\Http\Controllers\Admin\SellerController::class, 'show'])->name('admin.sellerdetail');
    Route::view('/admin/addproduct', 'admin.addproduct')->name('admin.addproduct');
    Route::view('/admin/transactions', 'admin.transactions')->name('admin.transactions');
    Route::view('/admin/reviews', 'admin.reviews')->name('admin.reviews');
    Route::get('/admin/brands', [\App\Http\Controllers\Admin\BrandController::class, 'index'])->name('admin.brands');
    Route::post('/admin/brands', [\App\Http\Controllers\Admin\BrandController::class, 'store'])->name('admin.brands.store');
    Route::put('/admin/brands/{brand}', [\App\Http\Controllers\Admin\BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('/admin/brands/{brand}', [\App\Http\Controllers\Admin\BrandController::class, 'destroy'])->name('admin.brands.destroy');
    Route::get('/admin/customerslist', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customerslist');
    Route::get('/admin/customerdetail/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customerdetail');
    Route::get('/admin/customerorders/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, 'orders'])->name('admin.customerorders');    Route::view('/admin/adminsetting', 'admin.setting')->name('admin.settings');
    Route::get('/admin/sellerrequests', [\App\Http\Controllers\Admin\SellerController::class, 'requests'])->name('admin.sellerrequests');
    Route::post('/admin/sellers/{seller}/accept', [\App\Http\Controllers\Admin\SellerController::class, 'accept'])->name('admin.sellers.accept');
    Route::post('/admin/sellers/{seller}/reject', [\App\Http\Controllers\Admin\SellerController::class, 'reject'])->name('admin.sellers.reject');
});
Route::middleware(['auth','role:seller'])->group(function(){
    Route::get('/seller/dashboard',[SellerDashboardController::class,'dashboard'])->name('seller.dashboard');
    // Show KYC form page (only for sellers)
    Route::get('/seller/kyc', function () {
        return view('seller.kycform');
    })->name('seller.kyc');
    // POST route kept for form submission from the KYC form
    Route::post('/seller/kyc',[SellerDashboardController::class,'submitKyc'])->name('seller.kyc.submit');
    Route::view('/seller/productslist', 'seller.productslist')->name('seller.productslist');
    Route::view('/seller/orderlist', 'seller.orderlist')->name('seller.orderlist');
    Route::view('/seller/orderdetail', 'seller.orderdetail')->name('seller.orderdetail');
    Route::view('/seller/addproduct', 'seller.addproduct')->name('seller.addproduct');
    Route::view('/seller/transactions', 'seller.transactions')->name('seller.transactions');
    Route::view('/seller/reviews', 'seller.reviews')->name('seller.reviews');

    // Seller attributes management (each seller manages their own attributes)
    Route::get('/seller/attributes', [AttributeController::class, 'index'])->name('seller.attributes');
    Route::get('/seller/attributes/data', [AttributeController::class, 'data'])->name('seller.attributes.data');
    Route::post('/seller/attributes', [AttributeController::class, 'store'])->name('seller.attributes.store');
    Route::put('/seller/attributes/{attribute}', [AttributeController::class, 'update'])->name('seller.attributes.update');
    Route::delete('/seller/attributes/{attribute}', [AttributeController::class, 'destroy'])->name('seller.attributes.destroy');

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
    // Profile update (inline edit on My Account page)
    Route::post('/customer/profile',[ProfileController::class,'update'])->name('customer.profile.update');
});
