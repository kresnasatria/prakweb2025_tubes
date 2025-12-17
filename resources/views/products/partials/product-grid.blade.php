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
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-12">
        <p class="text-gray-500 text-lg">Produk tidak ditemukan</p>
    </div>
@endforelse