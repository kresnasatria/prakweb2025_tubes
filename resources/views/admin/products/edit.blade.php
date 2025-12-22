<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <!-- FULL WIDTH CONTAINER -->
        <div class="px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nama Produk
                        </label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Kategori
                        </label>
                        <select name="category_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Harga
                        </label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Stok
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Gambar Produk
                        </label>
                        <input type="file" name="image"
                            class="mt-1 block w-full text-sm text-gray-500">
                        
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="mt-3 h-32 object-cover rounded">
                        @endif
                    </div>

                    <!-- ACTION -->
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.products.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Update Produk
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
