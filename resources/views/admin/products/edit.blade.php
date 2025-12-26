@extends('layouts.app')

@section('content')
<div class="px-6 py-8 w-full">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui informasi produk
        </p>
    </div>

    {{-- ERROR GLOBAL --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-100 p-4 text-red-700">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="w-full max-w-4xl">

        @csrf
        @method('PUT')

        {{-- NAMA PRODUK --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Nama Produk
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $product->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:ring-blue-500 focus:border-blue-500"
                   required>

            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- KATEGORI --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Kategori
            </label>
            <select name="category_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                           focus:ring-blue-500 focus:border-blue-500"
                    required>

                <option value="">-- Pilih Kategori --</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>

            @error('category_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- HARGA --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Harga
            </label>
            <input type="number"
                   name="price"
                   value="{{ old('price', $product->price) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:ring-blue-500 focus:border-blue-500"
                   required>

            @error('price')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- STOK --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Status
            </label>

            <select name="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                        focus:ring-blue-500 focus:border-blue-500"
                    required>
                <option value="">-- Pilih Status --</option>

                <option value="available"
                    {{ old('status', $product->status ?? 'available') === 'available' ? 'selected' : '' }}>
                    Available
                </option>

                <option value="sold"
                    {{ old('status', $product->status) === 'sold' ? 'selected' : '' }}>
                    Sold
                </option>
            </select>

            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- DESKRIPSI --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Deskripsi Produk
            </label>

            <textarea name="description"
                      rows="4"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                             focus:ring-blue-500 focus:border-blue-500"
                      required>{{ old('description', $product->description) }}</textarea>

            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- GAMBAR --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">
                Gambar Produk
            </label>

            @if ($product->thumbnail)
                <img src="{{ asset($product->thumbnail) }}"
                     alt="Gambar Produk"
                     class="w-32 h-32 object-cover rounded-md mb-3">
            @endif

            <input type="file"
                   name="thumbnail"
                   class="mt-1 block w-full text-sm text-gray-600">

            @error('thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Update
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition">
                Batal
            </a>
        </div>

    </form>

</div>
@endsection