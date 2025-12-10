<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
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

    // Register (INI YANG KITA TAMBAHKAN)
    // Langsung return view karena controller register mungkin belum Anda buat
    Route::get('/register', function () {
        return view('auth.register'); 
    })->name('register');

    // Nanti jika sudah siap bikin fitur register, aktifkan baris ini:
    // Route::post('/register', [AuthController::class, 'register_process'])->name('register.process');
});


// Logout (Hanya untuk User Login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// --- 2. HALAMAN PUBLIK ---
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');


// --- 3. HALAMAN USER (Harus Login) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); 


// --- 4. HALAMAN ADMIN (Harus Login & Role Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Route Product Management (CRUD) nanti disini
});


// --- 5. PROFILE SETTINGS ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});