<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Selamat Datang, Admin!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                            <div class="text-indigo-500 text-sm font-bold uppercase">Total Produk</div>
                            <div class="text-3xl font-bold text-gray-800 mt-2">50</div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <div class="text-green-500 text-sm font-bold uppercase">Pesanan Baru</div>
                            <div class="text-3xl font-bold text-gray-800 mt-2">12</div>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                            <div class="text-yellow-600 text-sm font-bold uppercase">Total User</div>
                            <div class="text-3xl font-bold text-gray-800 mt-2">150</div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="#" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                            + Tambah Produk Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>