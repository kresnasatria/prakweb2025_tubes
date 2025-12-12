<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Lihat keranjang
     */
    public function view()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Tambah ke keranjang
     */
    public function add(Product $product)
    {
        // Cek stok produk
        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok ' . $product->name . ' habis!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            // Cek apakah quantity di cart + 1 melebihi stok
            if ($cart[$product->id]['quantity'] + 1 > $product->stock) {
                return back()->with('error', 'Stok ' . $product->name . ' tidak mencukupi. Tersedia: ' . $product->stock);
            }
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id] = ['quantity' => 1];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', $product->name . ' ditambahkan ke keranjang!');
    }

    /**
     * Hapus dari keranjang
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view')->with('success', 'Produk dihapus dari keranjang!');
    }

    /**
     * Update quantity
     */
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        // Validasi stok
        $product = Product::find($productId);
        if ($product && $quantity > $product->stock) {
            return redirect()->route('cart.view')
                ->with('error', 'Stok ' . $product->name . ' tidak mencukupi. Tersedia: ' . $product->stock);
        }

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Keranjang diperbarui!');
    }

    /**
     * Update semua quantity
     */
    public function updateAll(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);
        
        foreach ($quantities as $productId => $quantity) {
            $product = Product::find($productId);
            $qty = (int) $quantity;
            
            if ($qty <= 0) {
                unset($cart[$productId]);
            } elseif ($product && $qty <= $product->stock) {
                $cart[$productId]['quantity'] = $qty;
            }
        }
        
        session()->put('cart', $cart);
        return redirect()->route('cart.view')->with('success', 'Keranjang diperbarui!');
    }

    /**
     * Clear keranjang
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.view')->with('success', 'Keranjang dikosongkan!');
    }

    /**
     * Checkout
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Keranjang kosong!');
        }

        $items = [];
        $total = 0;
        $stockErrors = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                // Cek stok
                if ($product->stock < $item['quantity']) {
                    $stockErrors[] = "{$product->name} (tersedia: {$product->stock}, diminta: {$item['quantity']})";
                }
                
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }
        }

        // Jika ada produk yang stoknya tidak mencukupi
        if (!empty($stockErrors)) {
            return redirect()->route('cart.view')
                ->with('error', 'Stok tidak mencukupi untuk: ' . implode(', ', $stockErrors));
        }

        return view('orders.checkout', compact('items', 'total'));
    }
}
