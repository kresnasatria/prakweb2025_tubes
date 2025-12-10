<x-app-layout>
    {{-- BAGIAN 1: HEADER & SEARCH --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    Katalog Produk
                </h2>

                {{-- Form Pencarian & Filter --}}
                <form action="{{ route('products.index') }}" method="GET" class="flex w-full md:w-auto gap-2">
                    <select name="category" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari produk..." 
                           class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm w-full md:w-64">
                    
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm">
                        Cari
                    </button>
                </form>
            </div>

            {{-- BAGIAN 2: GRID PRODUK --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300 flex flex-col h-full">
                            
                            <div class="relative h-48 w-full bg-gray-200">
                                <img src="{{ $product->thumbnail ?? 'https://placehold.co/600x400' }}" 
                                     alt="{{ $product->name }}" 
                                     class="object-cover w-full h-full">
                                     
                                <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate">
                                    {{ $product->name }}
                                </h3>
                                
                                <p class="text-sm text-gray-600 line-clamp-2 mb-4 flex-grow">
                                    {{ Str::limit($product->description, 50) }}
                                </p>

                                <div class="mt-auto">
                                    <p class="text-xl font-bold text-blue-600 mb-3">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    
                                    <a href="{{ route('products.show', $product) }}" 
                                       class="block w-full text-center bg-gray-800 text-white py-2 rounded-md hover:bg-gray-700 transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- BAGIAN 3: PAGINATION (NAVIGASI HALAMAN) --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>

            @else
                {{-- Jika Produk Tidak Ditemukan --}}
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Produk tidak ditemukan.</p>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Reset Pencarian</a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>