<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    // Buat 1 Akun Admin
\App\Models\User::factory()->create([
    'name' => 'Admin Toko',
    'email' => 'admin@toko.com',
    'password' => bcrypt('password'), // Password simpel dulu
    'role' => 'admin', // <--- Kuncinya di sini
]);
    // Logika: Buat 5 Kategori, dan SETIAP kategori memiliki 10 Produk.
    // Total akan ada 5 Kategori dan 50 Produk.
    
    Category::factory(5)
        ->has(Product::factory()->count(10), 'products')
        ->create();
}
}
