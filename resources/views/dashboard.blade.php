<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pesanan</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ Auth::user()->orders()->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
            <h3 class="text-gray-500 text-sm font-semibold">Total Pengeluaran</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format(Auth::user()->orders()->sum('total_amount'), 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
            <h3 class="text-gray-500 text-sm font-semibold">Profile</h3>
            <p class="text-sm text-gray-600 mt-2">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <p class="text-gray-600">Belum ada aktivitas.</p>
    </div>
</x-app-layout>
