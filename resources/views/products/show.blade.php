@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        <div class="relative bg-gray-100 flex items-center justify-center" style="min-height: 500px;">
                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-sm text-blue-500 font-medium">{{ $product->category->name }}</span>
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2 uppercase">{{ $product->name }}</h1>
                        <div class="text-3xl font-bold text-gray-900 mb-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <div class="space-y-3 mb-6">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-lg hover:bg-gray-800 transition-colors mb-2">
                                        + Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="font-bold text-gray-900 mb-3">Detail</h3>
                            <div class="space-y-2 text-sm">
                                <span id="short-description">{{ Str::limit($product->description, 200) }}</span>
                                <span id="full-description" style="display: none;">{{ $product->description }}</span>
                                <button id="toggle-description" class="text-blue-600 text-sm mt-2 hover:underline">Selengkapnya</button>
                            </div>
                            <div class="space-y-2 text-sm mt-3 font-semibold">
                                @if ($product->stock > 0)
                                    <span class="text-green-700">Stok tersedia: {{ $product->stock }}</span>
                                @else
                                    <span class="text-red-500">Stok habis</span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t mt-6 pt-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Perlindungan Pembeli</p>
                                    <p class="text-xs text-gray-500">Jaminan aman dan garansi uang kembali.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Serupa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @include('products.partial.product-grid', ['products' => $relatedProducts])
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggle-description').addEventListener('click', function() {
            var short = document.getElementById('short-description');
            var full = document.getElementById('full-description');
            var button = this;
            if (full.style.display === 'none') {
                short.style.display = 'none'; full.style.display = 'inline'; button.textContent = 'Sembunyikan';
            } else {
                short.style.display = 'inline'; full.style.display = 'none'; button.textContent = 'Selengkapnya';
            }
        });
    </script>
@endsection