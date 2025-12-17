<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex justify-center bg-gray-100 rounded-lg p-4">
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="object-contain h-96 w-full rounded-lg">
                    </div>

                    <div>
                        <span class="text-sm text-gray-500 uppercase tracking-wide font-semibold">
                            {{ $product->category->name ?? 'Umum' }}
                        </span>
                        
                        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4">
                            {{ $product->name }}
                        </h1>

                        <div class="text-2xl font-semibold text-indigo-600 mb-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ $product->description }}
                        </p>

                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-700 font-medium">Stok: {{ $product->stock }}</span>
                            </div>

                            <div class="flex space-x-4">
                                <button class="flex-1 bg-indigo-600 text-black font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>