<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                        <textarea name="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-black py-3 rounded-md hover:bg-green-700 font-semibold">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-2 border-b pb-4 mb-4">
                    @foreach($items as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item['product']->name }} x{{ $item['quantity'] }}</span>
                            <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>