<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4 rounded">
                        
                        <span class="text-xs text-gray-500 uppercase tracking-wide">
                            {{ $product->category->name }}
                        </span>
                        
                        <h3 class="text-lg font-bold text-gray-900 mt-1 truncate">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="mt-2 text-indigo-600 font-semibold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <button class="mt-4 w-full bg-gray-800 text-white py-2 px-4 rounded hover:bg-gray-700 transition">
                            Lihat Detail
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 p-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>