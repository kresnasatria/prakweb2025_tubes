<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Siapkan Query (pakai 'with' agar hemat query database)
        $query = Product::with('category');

        // 2. Logika Search (Jika ada input 'search')
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Logika Filter Kategori (Jika ada input 'category')
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 4. Ambil data (12 produk per halaman)
        // withQueryString() penting agar saat pindah halaman, search tidak hilang
        $products = $query->latest()->paginate(12)->withQueryString();

        // 5. Ambil daftar kategori untuk dropdown
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}