<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md text-red-600">
            {{ session('error') }}
        </div>
    @endif

    @if (count($items) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Items --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <form action="{{ route('cart.updateAll') }}" method="POST" id="cart-form">
                        @csrf
                        @foreach ($items as $item)
                            <div class="p-4 border-b flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $item['product']->thumbnail ?? 'https://placehold.co/80x80' }}"
                                        alt="{{ $item['product']->name }}" class="w-16 h-16 object-cover rounded">
                                    <div>
                                        <p class="font-semibold">{{ $item['product']->name }}</p>
                                        <p class="text-gray-500 text-sm">Rp
                                            {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400">Stok tersedia: {{ $item['product']->stock }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="number" name="quantities[{{ $item['product']->id }}]"
                                        value="{{ $item['quantity'] }}" min="1"
                                        max="{{ $item['product']->stock }}"
                                        class="w-20 border border-gray-300 rounded px-2 py-1 text-center">

                                    {{-- Tombol hapus menggunakan JavaScript --}}
                                    <button type="button"
                                        onclick="if(confirm('Hapus {{ $item['product']->name }} dari keranjang?')) document.getElementById('remove-form-{{ $item['product']->id }}').submit();"
                                        class="bg-red-500 text-black px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>

                                <p class="font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        @endforeach

                        <div class="p-4 flex gap-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    {{-- Hidden forms untuk hapus (di luar form utama) --}}
                    @foreach ($items as $item)
                        <form id="remove-form-{{ $item['product']->id }}"
                            action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endforeach
                </div>
            </div>

            {{-- Summary --}}
            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Ringkasan</h3>

                    <div class="flex justify-between text-xl font-bold mb-6">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    @auth
                        <a href="{{ route('orders.checkout') }}"
                            class="block w-full text-center bg-green-600 text-black py-3 rounded-md hover:bg-green-700 font-semibold mb-2">
                            Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-blue-600 text-black py-3 rounded-md hover:bg-blue-700 font-semibold mb-2">
                            Login untuk Checkout
                        </a>
                    @endauth

                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-400"
                            onclick="return confirm('Kosongkan keranjang?')">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-gray-500 text-lg mb-4">Keranjang belanja kosong</p>
            <a href="{{ route('products.index') }}"
                class="bg-blue-600 text-black px-6 py-2 rounded-md hover:bg-blue-700">
                Lanjut Belanja
            </a>
        </div>
    @endif
</x-app-layout>
