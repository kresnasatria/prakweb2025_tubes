<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        {{-- Total Pemasukan --}}
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pemasukan</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">
                Rp {{ number_format(\App\Models\Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.') }}
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Produk</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Product::count() }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Kategori</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Category::count() }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pesanan</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Order::count() }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total User</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Kelola Produk</h2>
            <a href="{{ route('admin.products.index') }}" class="bg-indigo-600 text-black px-4 py-2 rounded-lg hover:bg-indigo-700">
                Lihat Produk
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Kelola Kategori</h2>
            <a href="{{ route('admin.categories.index') }}" class="bg-indigo-600 text-black px-4 py-2 rounded-lg hover:bg-indigo-700">
                Lihat Kategori
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Kelola Pesanan</h2>
            <a href="{{ route('admin.orders.index') }}" class="bg-indigo-600 text-black px-4 py-2 rounded-lg hover:bg-indigo-700">
                Lihat Pesanan
            </a>
        </div>
    </div>

    {{-- Detail Pemasukan --}}
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">📊 Ringkasan Pemasukan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Pemasukan Hari Ini --}}
            <div class="bg-green-50 rounded-lg p-4">
                <p class="text-sm text-green-600 font-semibold">Hari Ini</p>
                <p class="text-2xl font-bold text-green-700">
                    Rp {{ number_format(\App\Models\Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount'), 0, ',', '.') }}
                </p>
            </div>
            
            {{-- Pemasukan Bulan Ini --}}
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm text-blue-600 font-semibold">Bulan Ini</p>
                <p class="text-2xl font-bold text-blue-700">
                    Rp {{ number_format(\App\Models\Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_amount'), 0, ',', '.') }}
                </p>
            </div>
            
            {{-- Total Keseluruhan --}}
            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-sm text-purple-600 font-semibold">Total Keseluruhan</p>
                <p class="text-2xl font-bold text-purple-700">
                    Rp {{ number_format(\App\Models\Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>