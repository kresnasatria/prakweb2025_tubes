@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
        <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-600">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md text-red-600">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">No. Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</p>
                    </div>
                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-gray-500 text-sm mt-4">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="p-6 border-b"><h3 class="text-lg font-semibold text-gray-900">Item Pesanan</h3></div>
                <div class="divide-y">
                    @foreach($order->orderItems as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                @php
                                    $thumb = $item->product->thumbnail ?? null;
                                    $thumbUrl = $thumb
                                    ? (\Illuminate\Support\Str::startsWith($thumb, ['http://','https://']) ? $thumb : asset(ltrim($thumb, '/')))
                                    : 'https://placehold.co/80x80';
                                @endphp

                                <img src="{{ $thumbUrl }}" class="w-20 h-20 object-cover rounded">

                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h3>
                <p class="text-gray-600 mb-2">{{ $order->shipping_address }}</p>
                <p class="text-gray-600">Telepon: {{ $order->phone }}</p>
                @if($order->notes) <p class="text-gray-600 mt-2">Catatan: {{ $order->notes }}</p> @endif
            </div>

            @if($order->status === 'pending')
            <div class="bg-white rounded-lg shadow p-6 mt-6 border-2 border-blue-100">
                <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                    Pembayaran QRIS
                </h3>
                <p class="text-sm text-gray-600 mb-4">Scan QRIS di bawah ini menggunakan aplikasi e-wallet atau mobile banking Anda untuk menyelesaikan pembayaran.</p>
                
                <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl">
                    <img src="{{ asset('images/vikensa.jpeg') }}" 
                         alt="Scan QRIS untuk membayar" 
                         class="w-64 h-auto border-4 border-white rounded-xl shadow-md">
                    
                    <p class="text-sm font-medium text-gray-500 mt-4 uppercase tracking-wider">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>

                <p class="text-sm text-gray-600 mb-4">Kirim bukti pembayaran ke nomor WhatsApp berikut setelah melakukan pembayaran: <a href="https://wa.me/1234567890" class="text-blue-600 underline">123-456-7890</a>.</p>
                
            </div>
            @endif

        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                <div class="space-y-3 border-b pb-4 mb-4">
                    <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between text-gray-600"><span>Ongkos Kirim</span><span>-</span></div>
                </div>
                <div class="flex justify-between text-xl font-bold text-gray-900 mb-6">
                    <span>Total</span><span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 mb-3" onclick="return confirm('Batalkan pesanan?')">Batalkan Pesanan</button>
                    </form>
                @endif

                @if(in_array($order->status, ['completed', 'cancelled']))
                    <form action="{{ route('orders.destroy', $order) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 mb-3" onclick="return confirm('Hapus pesanan?')">Hapus Pesanan</button>
                    </form>
                @endif

                <a href="{{ route('orders.invoice', $order) }}" class="block text-center w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition">📄 Download Invoice PDF</a>
            </div>
        </div>
    </div>
@endsection