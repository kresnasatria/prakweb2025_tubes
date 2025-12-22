<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Lihat semua pesanan user yang logi
     */
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Lihat detail satu pesanan
     */
    public function show(Order $order)
    {
        // Pastikan user hanya bisa lihat order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses pesanan ini');
        }

        $order->load('orderItems.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Buat pesanan baru dari keranjang
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        // Ambil cart dari session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang belanja kosong');
        }

        // Validasi stok terlebih dahulu
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) {
                return redirect()->route('cart.index')
                    ->with('error', 'Produk tidak ditemukan');
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$product->name} tidak mencukupi. Tersedia: {$product->stock}");
            }
        }

        // Hitung total
        $totalAmount = 0;
        $orderItems = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) continue;

            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;
            $orderItems[] = [
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ];
        }

        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'shipping_address' => $validated['shipping_address'],
            'phone' => $validated['phone'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Insert order items dan kurangi stok
        foreach ($orderItems as $item) {
            OrderItem::create(array_merge(['order_id' => $order->id], $item));
            
            // Kurangi stok produk
            Product::where('id', $item['product_id'])
                ->decrement('stock', $item['quantity']);
        }

        // Clear session cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Cancel order (hanya status pending)
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan pending yang bisa dibatalkan');
        }

        // Kembalikan stok produk
        foreach ($order->orderItems as $item) {
            Product::where('id', $item->product_id)
                ->increment('stock', $item->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan dibatalkan');
    }

    /**
     * Hapus pesanan (hanya completed atau cancelled)
     */
    public function destroy(Order $order)
    {
        // Cek kepemilikan atau admin
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Hanya bisa hapus yang completed atau cancelled
        $deletableStatuses = ['completed', 'cancelled'];

        if (!in_array($order->status, $deletableStatuses)) {
            return back()->with('error', 'Hanya pesanan selesai atau batal yang bisa dihapus');
        }


        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus');
    }

    /**
     * Download Invoice PDF
     */
    public function downloadInvoice(Order $order)
    {
        // Pastikan user hanya bisa download invoice miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses invoice ini');
        }

        $order->load('orderItems.product', 'user');

        $pdf = Pdf::loadView('orders.invoice-pdf', compact('order'));
        
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
}
