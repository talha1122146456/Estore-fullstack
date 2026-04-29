<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\SalesController;

/*
|--------------------------------------------------------------------------
| 1. Public Storefront (Guest & Users)
|--------------------------------------------------------------------------
*/
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{product}', [ShopController::class, 'show'])->name('shop.show');

// Tracking: Public but rate-limited
Route::middleware('throttle:10,1')->group(function () {
    Route::get('/track', [ShopController::class, 'trackOrder'])->name('shop.track');
    Route::get('/track/search', [ShopController::class, 'searchOrder'])->name('shop.track.search');
});

/*
|--------------------------------------------------------------------------
| 2. Authentication (Simple Login - No OTP)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout is only for logged-in users
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| 3. Cart & Checkout (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->as('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
});

// SECURE: Only logged-in users can reach checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
});

/*
|--------------------------------------------------------------------------
| 4. Admin Routes (Strictly Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
        
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        // Sales Management
        Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
        Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
        Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.store');
        Route::get('/sales/{sale}/edit', [SalesController::class, 'edit'])->name('sales.edit');
        Route::put('/sales/{sale}/update', [SalesController::class, 'update'])->name('sales.update');
        Route::delete('/sales/{sale}/delete', [SalesController::class, 'destroy'])->name('sales.destroy');

        // Order Management
        Route::get('/orders', [ProductController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{order}', [ProductController::class, 'orderShow'])->name('orders.show');
        Route::post('/orders/{order}/status', [ProductController::class, 'orderUpdateStatus'])->name('orders.updateStatus');
        Route::get('/orders/{order}/invoice', [ProductController::class, 'orderInvoice'])->name('orders.invoice');
});