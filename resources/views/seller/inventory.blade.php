<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-6 py-4 text-green-700 shadow-sm">
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gray-100 bg-white px-6 py-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight text-gray-900">Manajemen Stok Makanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Kelola sisa makanan hari ini agar tidak terbuang sia-sia.</p>
                    </div>
                    <a href="{{ route('food.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-600">
                        + Tambah Makanan
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Info Makanan</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Harga</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-400">Sisa Stok</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">Waktu Pickup</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($foods as $food)
                                <tr class="transition hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-gray-800">{{ $food->name }}</p>
                                        <p class="mt-1 text-xs text-gray-400">{{ $food->description ?: 'Tidak ada deskripsi' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-extrabold text-orange-600">Rp {{ number_format($food->discount_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center rounded-md px-3 py-1 text-xs font-bold {{ $food->stock > 0 ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $food->stock }} porsi
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse($food->pickup_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($food->pickup_time_end)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form
                                            action="{{ route('food.destroy', $food->id) }}"
                                            method="POST"
                                            id="delete-form-{{ $food->id }}"
                                            data-confirm-submit
                                            data-confirm-title="Hapus makanan ini?"
                                            data-confirm-text="Menu akan dihapus permanen dari katalog dan tidak bisa dikembalikan."
                                            data-confirm-button="Ya, hapus"
                                            data-confirm-icon="warning"
                                            data-loading-message="Makanan sedang dihapus."
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" data-loading-text="Menghapus..." class="text-gray-400 transition hover:text-red-600">
                                                <svg class="inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center font-medium text-gray-500">Belum ada makanan yang diunggah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
