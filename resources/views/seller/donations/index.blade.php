<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-6 py-4 text-green-700 shadow-sm">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold tracking-tight text-gray-900">Donasi ke Bank Makanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Kelola daftar makanan yang ingin kamu donasikan tanpa transaksi jual-beli.</p>
                    </div>
                    <a href="{{ route('seller.donations.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-orange-500 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-600">
                        + Tambah Donasi
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 xl:grid-cols-3">
                    @forelse($donations as $donation)
                        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                            @if($donation->image)
                                <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->name }}" class="h-40 w-full object-cover">
                            @else
                                <div class="flex h-40 items-center justify-center border-b border-orange-100 bg-orange-50 text-sm font-medium text-orange-300">
                                    Bank Makanan
                                </div>
                            @endif

                            <div class="space-y-4 p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-bold text-slate-900">{{ $donation->name }}</h4>
                                        <p class="mt-1 text-sm text-slate-500">{{ $donation->description ?: 'Tidak ada detail tambahan.' }}</p>
                                    </div>
                                    <span class="inline-flex rounded-md bg-orange-100 px-3 py-1 text-xs font-extrabold uppercase tracking-wide text-orange-600">
                                        {{ $donation->stock }} porsi
                                    </span>
                                </div>

                                <div class="rounded-xl border border-orange-100 bg-orange-50 px-4 py-3 text-sm text-slate-700">
                                    Status donasi: <span class="font-bold text-orange-600">{{ $donation->status === 'available' ? 'Siap disalurkan' : 'Sudah disalurkan' }}</span>
                                </div>

                                <form
                                    action="{{ route('seller.donations.destroy', $donation->id) }}"
                                    method="POST"
                                    data-confirm-submit
                                    data-confirm-title="Hapus data donasi ini?"
                                    data-confirm-text="Data donasi akan dihapus dari daftar bank makanan."
                                    data-confirm-button="Ya, hapus"
                                    data-confirm-icon="warning"
                                    data-loading-message="Data donasi sedang dihapus."
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" data-loading-text="Menghapus..." class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                        Hapus Donasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-orange-200 bg-orange-50/50 px-6 py-16 text-center">
                            <p class="text-lg font-bold text-slate-900">Belum ada data donasi.</p>
                            <p class="mt-2 text-sm text-slate-500">Tambahkan makanan donasi yang akan disalurkan ke bank makanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
