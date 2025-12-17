<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. OTENTIKASI MANUAL ---

// Group Middleware 'guest' artinya hanya bisa diakses jika BELUM login
Route::middleware('guest')->group(function () {
    
    // Login
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');

    // Register 
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_process'])->name('register.process');});


// Logout (Hanya untuk User Login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// --- 2. CART ROUTES (Harus Login) ---
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('orders.checkout');
    Route::post('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');
});


// --- 3. HALAMAN PUBLIK ---
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');




// Orders (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});


// --- 5. HALAMAN ADMIN (Harus Login & Role Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD Products
    Route::resource('products', AdminProductController::class);

    // CRUD Categories
    Route::resource('categories', AdminCategoryController::class);

    // CRUD Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});


// --- 5. PROFILE SETTINGS ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});