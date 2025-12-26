@extends('layouts.app')

@section('content')
<div class="px-6 py-8 w-full">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Produk</h1>
        <p class="text-sm text-gray-500 mt-1">
            Form untuk menambahkan produk baru
        </p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="w-full bg-white border border-gray-200 rounded-lg p-6">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kiri --}}
            <div>
                {{-- NAMA PRODUK --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- KATEGORI --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Kanan --}}
            <div>
                {{-- HARGA --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- STATUS (GANTI STOK) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">-- Pilih Status --</option>
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
            <textarea name="description" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      required>{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- GAMBAR --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
            <input type="file" name="thumbnail" class="mt-1 block w-full text-sm text-gray-600 border border-gray-300 rounded-md p-2">
            @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Simpan Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                Batal
            </a>
        </div>

    </form>

</div>
@endsection
