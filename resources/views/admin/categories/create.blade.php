@extends('layouts.app')

@section('content')
<div class="px-6 py-8 w-full max-w-3xl">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Kategori</h1>
        <p class="text-sm text-gray-500 mt-1">
            Tambahkan kategori baru untuk produk
        </p>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="bg-white border border-gray-200 rounded-lg p-6">

        @csrf

        {{-- NAMA KATEGORI --}}
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Kategori
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ICON --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Icon (opsional)
            </label>
            <input type="text"
                   name="icon"
                   value="{{ old('icon') }}"
                   placeholder="contoh: fa-shirt / emoji / teks"
                   class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- ACTION --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                Simpan
            </button>

            <a href="{{ route('admin.categories.index') }}"
               class="bg-gray-200 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-300 transition">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
