<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
            <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Informasi Pesanan --}}
        <div class="lg:col-span-2">
            {{-- Header --}}
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
                        @else bg-red-100 text-red-800
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-gray-500 text-sm mt-4">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>

            {{-- Items --}}
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Item Pesanan</h3>
                </div>
                <div class="divide-y">
                    @foreach($order->orderItems as $item)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ $item->product->thumbnail ?? 'https://placehold.co/80x80' }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-20 h-20 object-cover rounded">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}
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

            {{-- Alamat Pengiriman --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h3>
                <p class="text-gray-600 mb-2">{{ $order->shipping_address }}</p>
                <p class="text-gray-600">Telepon: {{ $order->phone }}</p>
                @if($order->notes)
                    <p class="text-gray-600 mt-2">Catatan: {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        {{-- Summary --}}
        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                
                <div class="space-y-3 border-b pb-4 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span>-</span>
                    </div>
                </div>

                <div class="flex justify-between text-xl font-bold text-gray-900 mb-6">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif

                @if(in_array($order->status, ['completed', 'cancelled']))
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                onclick="return confirm('Yakin hapus pesanan ini?')">
                            Hapus Pesanan
                        </button>
                    </form>
                @endif

                <a href="{{ route('orders.invoice', $order) }}" 
                   class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    📄 Download Invoice PDF
                </a>
            </div>
        </div>
    </div>
</x-app-layout>