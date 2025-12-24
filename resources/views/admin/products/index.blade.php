@extends('layouts.app')

@section('content')
<div class="px-6 py-8 w-full">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
            <p class="text-sm text-gray-500 mt-1">
                Daftar seluruh produk yang tersedia
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition">
            + Tambah Produk
        </a>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white border rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100 text-left text-sm text-gray-600">
                <tr>
                    <th class="px-4 py-3 border-b">No</th>
                    <th class="px-4 py-3 border-b">Nama Produk</th>
                    <th class="px-4 py-3 border-b">Kategori</th>
                    <th class="px-4 py-3 border-b">Harga</th>
                    <th class="px-4 py-3 border-b">Stok</th>
                    <th class="px-4 py-3 border-b text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700">
                @forelse ($products as $index => $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border-b">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 border-b font-medium">
                            {{ $product->name }}
                        </td>
                        <td class="px-4 py-3 border-b">
                            {{ $product->category->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 border-b">
                            Rp {{ number_format($product->price,0,',','.') }}
                        </td>
                        <td class="px-4 py-3 border-b">
                            {{ $product->stock }}
                        </td>
                        <td class="px-4 py-3 border-b text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="px-3 py-1.5 text-xs font-medium text-yellow-500 border border-yellow-500 rounded-md hover:bg-yellow-50 transition">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 text-xs font-medium text-red-600 border border-red-600 rounded-md hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Data produk belum tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection