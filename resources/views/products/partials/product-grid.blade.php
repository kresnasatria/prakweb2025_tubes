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
            <p class="text-sm text-gray-500 mt-1"> @php
                            $status = $product->status ?? (($product->stock ?? 0) > 0 ? 'available' : 'sold');
                        @endphp

                        @if($status === 'sold')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-700">
                                Sold
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-700">
                                Available
                            </span>
                        @endif </p>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-12">
        <p class="text-gray-500 text-lg">Produk tidak ditemukan</p>
    </div>
@endforelse