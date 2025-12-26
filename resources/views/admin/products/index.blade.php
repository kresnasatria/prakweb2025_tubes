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

    {{-- SEARCH FORM --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6 flex items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
               class="px-3 py-2 border rounded-md w-64 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="ml-2 text-sm text-gray-500 hover:underline">Reset</a>
        @endif
    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white border rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100 text-left text-sm text-gray-600">
                <tr>
                    <th class="px-4 py-3 border-b">No</th>
                    <th class="px-4 py-3 border-b">Nama Produk</th>
                    <th class="px-4 py-3 border-b">Kategori</th>
                    <th class="px-4 py-3 border-b">Harga</th>

                    {{-- GANTI: Stok -> Status --}}
                    <th class="px-4 py-3 border-b">Status</th>

                    <th class="px-4 py-3 border-b text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700">
                @include('admin.products.partials.table', ['products' => $products])
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="mt-6 flex justify-center">
            <div class="inline-block">
                {!! $products->links('pagination::tailwind') !!}
            </div>
        </div>
    </div>

    {{-- LIVE SEARCH SCRIPT --}}
    <script src="/js/admin-product-live-search.js"></script>
</div>
@endsection
