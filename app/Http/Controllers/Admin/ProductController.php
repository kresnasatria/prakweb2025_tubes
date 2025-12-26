<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax() || $request->input('ajax')) {
            $html = view('admin.products.partials.table', compact('products'))->render();
            $pagination = $products->links('pagination::tailwind')->toHtml();
            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        // mapping status -> stock (biar sistem cart/order yang masih pakai stock tetap aman)
        if ($validated['status'] === 'sold') {
            $validated['stock'] = 0;
        } else {
            $validated['stock'] = 1; // minimal stok untuk available
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateData($request);

        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        }

        // mapping status -> stock
        if ($validated['status'] === 'sold') {
            $validated['stock'] = 0;
        } else {
            // kalau available, pastiin stok minimal 1
            $validated['stock'] = max((int) $product->stock, 1);
        }

        DB::transaction(function () use ($request, $product, &$validated) {

            if ($request->hasFile('thumbnail')) {
                if ($product->thumbnail) {
                    $old = ltrim(str_replace('/storage/', '', $product->thumbnail), '/');
                    Storage::disk('public')->delete($old);
                }

                $path = $request->file('thumbnail')->store('products', 'public');
                $validated['thumbnail'] = '/storage/' . $path;
            }

            $product->update($validated);
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail) {
            $path = ltrim(str_replace('/storage/', '', $product->thumbnail), '/');
            Storage::disk('public')->delete($path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',

            // ✅ status enum
            'status' => 'required|in:available,sold',

            'thumbnail' => 'nullable|image|max:2048',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Available atau Sold.',
        ]);
    }
}
