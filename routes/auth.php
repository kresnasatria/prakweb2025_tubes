<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Manual - Tanpa Breeze)
|--------------------------------------------------------------------------
*/

// Routes untuk Guest (belum login)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('login.process');

    // Register
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'register_process'])->name('register.process');
});

// Routes untuk User yang sudah login
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
