<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola produk dan pesanan</p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Produk</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Kategori</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pesanan</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total User</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Kelola Produk</h2>
            <p class="text-gray-600 text-sm mb-4">Tambah, edit, atau hapus produk dari sistem.</p>
            <a href="#" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                Lihat Produk
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Kelola Kategori</h2>
            <p class="text-gray-600 text-sm mb-4">Buat atau edit kategori produk.</p>
            <a href="#" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                Lihat Kategori
            </a>
        </div>
    </div>
</x-app-layout>
