<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// --- 1. HALAMAN PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// --- 2. HALAMAN USER (Harus Login) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- 3. HALAMAN ADMIN (Harus Login & Role Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Kita akan buat file view-nya sebentar lagi
    })->name('dashboard');

    // Nanti kita tambah route produk di sini (create, store, edit, delete)
});

// --- 4. PROFILE SETTINGS ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';