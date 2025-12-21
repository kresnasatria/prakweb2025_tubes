<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>

            <a href="{{ route('admin.products.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE FULL WIDTH --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Produk
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Harga
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Stok
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img
                                    src="{{ $product->thumbnail ?? 'https://placehold.co/60x60' }}"
                                    class="w-14 h-14 rounded-md object-cover border"
                                >
                                <span class="font-medium text-gray-900">
                                    {{ $product->name }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $product->category->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-gray-800">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded-full
                                {{ $product->stock > 0
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">
                                {{ $product->stock }} stok
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="inline-block bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Belum ada produk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-app-layout>
