<x-app-layout>
    {{-- Hero Section untuk Tamu --}}
    @guest
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-black rounded-xl shadow-xl p-10 mb-10 -mt-6 -mx-4 sm:-mx-6 lg:-mx-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-extrabold mb-4">Toko Laravel</h1>
                <p class="text-xl text-black mb-8">Temukan produk berkualitas dengan harga terbaik.<br>Belanja mudah, cepat, dan aman!</p>
                <div class="flex justify-center gap-4 flex-wrap">
                </div>
            </div>
        </div>

        {{-- Keunggulan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-4xl mb-3">📦</div>
                <h3 class="font-bold text-gray-800 mb-2">Gratis Ongkir</h3>
                <p class="text-gray-500 text-sm">Pengiriman gratis untuk pembelian tertentu</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-4xl mb-3">✅</div>
                <h3 class="font-bold text-gray-800 mb-2">Produk Original</h3>
                <p class="text-gray-500 text-sm">100% produk asli berkualitas tinggi</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="text-4xl mb-3">💳</div>
                <h3 class="font-bold text-gray-800 mb-2">Pembayaran Aman</h3>
                <p class="text-gray-500 text-sm">Transaksi dijamin aman dan terpercaya</p>
            </div>
        </div>
    @endguest

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                @guest
                    Produk Terbaru
                @else
                    Katalog Produk
                @endguest
            </h1>
            @auth
            @endauth
        </div>
    </x-slot>

    <div class="mb-8">
        {{-- Search & Filter Section --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form id="filterForm" method="GET" action="{{ route('products.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    
                    {{-- Live Search --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                        <input type="text" 
                               name="search" 
                               id="searchInput"
                               value="{{ request('search') }}"
                               placeholder="Ketik nama produk..."
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Filter Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="categoryFilter" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Harga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Min</label>
                        <input type="number" 
                               name="min_price" 
                               value="{{ request('min_price') }}"
                               placeholder="0"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Max</label>
                        <input type="number" 
                               name="max_price" 
                               value="{{ request('max_price') }}"
                               placeholder="1000000"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    {{-- Sort --}}
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Urutkan:</label>
                        <select name="sort" id="sortFilter" class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Reset
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Results Info --}}
        <div class="flex justify-between items-center mb-4">
            <p class="text-gray-600">
                Menampilkan <span class="font-semibold">{{ $products->total() }}</span> produk
                @if(request('search'))
                    untuk "<span class="font-semibold">{{ request('search') }}</span>"
                @endif
            </p>
        </div>

        {{-- Product Grid --}}
        <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ $product->thumbnail ?? 'https://placehold.co/300x200' }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <span class="text-xs text-blue-600 font-semibold">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h3 class="font-semibold text-gray-800 mt-1 truncate">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-lg font-bold text-green-600 mt-2">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Stok: {{ $product->stock }}</p>
                        
                        {{-- Add to Cart Button --}}
                        <div class="mt-4 flex gap-2">
                            @if($product->stock > 0)
                                @auth
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 text-sm font-semibold transition">
                                            + Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="flex-1 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 text-center text-sm font-semibold transition">
                                        Login untuk Beli
                                    </a>
                                @endauth
                                <a href="{{ route('products.show', $product->slug) }}" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-md hover:bg-gray-300 text-center text-sm font-semibold transition">
                                    Lihat
                                </a>
                            @else
                                <button type="button" disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-md text-sm font-semibold cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Produk tidak ditemukan</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div id="pagination" class="mt-8">
            {{ $products->links() }}
        </div>
    </div>

    {{-- Live Search Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const sortFilter = document.getElementById('sortFilter');
            let debounceTimer;

            // Live Search dengan debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchProducts();
                }, 500);
            });

            // Auto submit saat filter berubah
            categoryFilter.addEventListener('change', fetchProducts);
            sortFilter.addEventListener('change', fetchProducts);

            function fetchProducts() {
                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);

                window.history.replaceState({}, '', `${window.location.pathname}?${params}`);

                fetch(`{{ route('products.index') }}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('productGrid').innerHTML = data.html;
                    document.getElementById('pagination').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
</x-app-layout>