<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil data produk, urutkan terbaru, dan loading relasi kategori (Eager Loading biar cepat)
        // Kita pakai paginate(12) agar tidak berat me-load 50 produk sekaligus
        $products = Product::with('category')->latest()->paginate(12);

        return view('products.index', compact('products'));
    }
}