@extends('layouts.app')

@section('content')
<div class="px-6 py-8 w-full">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">
            Ringkasan data dan performa sistem
        </p>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
        <div class="bg-white border rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Pemasukan</p>
            <p class="text-2xl font-bold text-green-600 mt-2">
                Rp {{ number_format(\App\Models\Order::where('status','completed')->sum('total_amount'),0,',','.') }}
            </p>
        </div>

        <div class="bg-white border rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="text-2xl font-bold mt-2">
                {{ \App\Models\Product::count() }}
            </p>
        </div>

        <div class="bg-white border rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Kategori</p>
            <p class="text-2xl font-bold mt-2">
                {{ \App\Models\Category::count() }}
            </p>
        </div>

        <div class="bg-white border rounded-lg p-6">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <p class="text-2xl font-bold mt-2">
                {{ \App\Models\Order::count() }}
            </p>
        </div>

        <div class="bg-white border rounded-lg p-6">
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-2xl font-bold mt-2">
                {{ \App\Models\User::count() }}
            </p>
        </div>
    </div>

    {{-- RINGKASAN PEMASUKAN --}}
    <div class="bg-white border rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">
            Ringkasan Pemasukan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border rounded-lg p-5 bg-green-50">
                <p class="text-sm text-green-700">Hari Ini</p>
                <p class="text-xl font-bold text-green-800 mt-1">
                    Rp {{ number_format(
                        \App\Models\Order::where('status','completed')
                        ->whereDate('created_at', today())
                        ->sum('total_amount'),0,',','.'
                    ) }}
                </p>
            </div>

            <div class="border rounded-lg p-5 bg-blue-50">
                <p class="text-sm text-blue-700">Bulan Ini</p>
                <p class="text-xl font-bold text-blue-800 mt-1">
                    Rp {{ number_format(
                        \App\Models\Order::where('status','completed')
                        ->whereMonth('created_at', now()->month)
                        ->sum('total_amount'),0,',','.'
                    ) }}
                </p>
            </div>

            <div class="border rounded-lg p-5 bg-purple-50">
                <p class="text-sm text-purple-700">Total Keseluruhan</p>
                <p class="text-xl font-bold text-purple-800 mt-1">
                    Rp {{ number_format(
                        \App\Models\Order::where('status','completed')
                        ->sum('total_amount'),0,',','.'
                    ) }}
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
