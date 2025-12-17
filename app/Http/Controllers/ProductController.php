<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Redirect admin ke admin dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 1. Siapkan Query (pakai 'with' agar hemat query database)
        $query = Product::with('category');

        // 2. Logika Search (Jika ada input 'search')
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 3. Logika Filter Kategori (Jika ada input 'category')
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // 4. Logika Filter Rentang Harga
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // 5. Logika Urutkan
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        // 6. Ambil data (12 produk per halaman)
        // withQueryString() penting agar saat pindah halaman, search tidak hilang
        $products = $query->paginate(12)->withQueryString();

        // 7. Ambil daftar kategori untuk dropdown
        $categories = Category::all();

        // Jika request AJAX, return partial view
        if ($request->ajax()) {
            return response()->json([
                'html' => view('products.partials.product-grid', compact('products'))->render(),
                'pagination' => (string) $products->links()
            ]);
        }

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        // Hapus gambar jika ada
        if ($product->thumbnail) {
            $path = str_replace('/storage/', '', $product->thumbnail);
            Storage::disk('public')->delete($path);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}