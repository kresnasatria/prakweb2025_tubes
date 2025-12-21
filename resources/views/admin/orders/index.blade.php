<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Pesanan</h1>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        No. Pesanan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $order->order_number }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $order->user->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-900">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="text-sm rounded-md border-gray-300
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                        Diproses
                                    </option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan
                                    </option>
                                </select>
                            </form>
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>

                        {{-- AKSI (SUDAH DIPERBAIKI) --}}
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-block bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                Detail
                            </a>

                            <form action="{{ route('admin.orders.destroy', $order) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada pesanan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</x-app-layout>
