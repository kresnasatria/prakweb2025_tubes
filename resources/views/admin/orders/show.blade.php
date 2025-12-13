<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            {{-- Info Pesanan --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500">No. Pesanan</p>
                        <p class="text-xl font-bold">{{ $order->order_number }}</p>
                    </div>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </form>
                </div>
                <p class="text-gray-500">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>

            {{-- Info Customer --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Customer</h3>
                <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Telepon:</strong> {{ $order->phone }}</p>
                <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                @if($order->notes)
                    <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                @endif
            </div>

            {{-- Items --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Item Pesanan</h3>
                </div>
                @foreach($order->orderItems as $item)
                    <div class="p-6 border-b flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ $item->product->thumbnail ?? 'https://placehold.co/80x80' }}" class="w-16 h-16 object-cover rounded">
                            <div>
                                <p class="font-semibold">{{ $item->product->name }}</p>
                                <p class="text-gray-500 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Summary --}}
        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="text-lg font-semibold mb-4">Ringkasan</h3>
                
                <div class="flex justify-between text-xl font-bold text-gray-900 mb-6">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                {{-- Tombol Download PDF --}}
                <a href="{{ route('admin.orders.invoice', $order) }}" 
                   class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-center block mb-3">
                    📄 Download Invoice PDF
                </a>

                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                            onclick="return confirm('Yakin hapus pesanan ini?')">
                        Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>