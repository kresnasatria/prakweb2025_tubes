@extends('layouts.app')

@section('content')
<div class="px-6 py-8 w-full">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap pesanan pelanggan
            </p>
        </div>
        <a href="{{ route('admin.orders.index') }}"
           class="text-sm text-gray-600 hover:text-gray-900">
            ← Kembali
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- KIRI --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- INFO PESANAN --}}
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">No. Pesanan</p>
                        <p class="text-xl font-bold text-gray-900">
                            {{ $order->order_number }}
                        </p>
                    </div>

                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                                onchange="this.form.submit()"
                                class="rounded-md border-gray-300 text-sm
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </form>
                </div>

                <p class="text-sm text-gray-500">
                    Tanggal Pesanan:
                    <span class="text-gray-700">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </span>
                </p>
            </div>

            {{-- INFO CUSTOMER --}}
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Informasi Customer
                </h3>

                <div class="space-y-2 text-sm">
                    <p><span class="font-medium">Nama:</span> {{ $order->user->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $order->user->email }}</p>
                    <p><span class="font-medium">Telepon:</span> {{ $order->phone }}</p>
                    <p><span class="font-medium">Alamat:</span> {{ $order->shipping_address }}</p>

                    @if($order->notes)
                        <p><span class="font-medium">Catatan:</span> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            {{-- ITEM PESANAN --}}
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Item Pesanan
                    </h3>
                </div>

                @foreach($order->orderItems as $item)
                    <div class="px-6 py-4 border-b flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                                                @php
                            $thumb = $item->product->thumbnail ?? null;
                            $thumbUrl = $thumb
                                ? (\Illuminate\Support\Str::startsWith($thumb, ['http://','https://']) ? $thumb : asset(ltrim($thumb, '/')))
                                : 'https://placehold.co/80x80';
                            @endphp

                            <img src="{{ $thumbUrl }}" class="w-20 h-20 object-cover rounded">


                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ $item->product->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                    × {{ $item->quantity }}
                                </p>
                            </div>
                        </div>

                        <p class="font-semibold text-gray-900">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- KANAN / RINGKASAN --}}
        <div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    Ringkasan Pesanan
                </h3>

                <div class="flex justify-between items-center text-xl font-bold mb-6">
                    <span>Total</span>
                    <span>
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('admin.orders.invoice', $order) }}"
                   class="block w-full text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition mb-3">
                    Download Invoice PDF
                </a>

                <form action="{{ route('admin.orders.destroy', $order) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin hapus pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition">
                        Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
