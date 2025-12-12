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
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
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

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
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

        return view('orders.checkout', compact('items', 'total'));
    }
}
