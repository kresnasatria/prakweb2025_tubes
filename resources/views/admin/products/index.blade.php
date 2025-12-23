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
                                   class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
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
