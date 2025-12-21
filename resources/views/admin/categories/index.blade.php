<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Kelola Kategori</h1>

            <a href="{{ route('admin.categories.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + Tambah Kategori
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
                        Nama Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Slug
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                        Jumlah Produk
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $category->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $category->slug }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                {{ $category->products_count }} produk
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="inline-block bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
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
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Belum ada kategori
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</x-app-layout>
