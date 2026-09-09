<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-4 sm:py-6">
        <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
            <div class="mb-5 sm:mb-6">
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Katalog Makanan</h1>
                <p class="mt-1 text-sm text-gray-500">Eksplorasi dan selamatkan makanan layak dari resto terdekat.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3">
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl">
                    <span class="font-medium text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse($foods as $food)
                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:shadow-md">
                        @if($food->image)
                            <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="h-32 w-full object-cover lg:h-28">
                        @else
                            <div class="flex h-32 w-full items-center justify-center border-b border-orange-100 bg-orange-50 lg:h-28">
                                <span class="text-orange-300 font-medium text-sm">ResQ-Food</span>
                            </div>
                        @endif

                        <div class="flex flex-1 flex-col p-4 lg:p-5">
                            <div class="mb-3 flex items-start justify-between">
                                <span class="rounded-md bg-orange-100 px-3 py-1 text-xs font-extrabold tracking-wide text-orange-600">
                                    SISA: {{ $food->stock }}
                                </span>
                            </div>

                            <h3 class="mb-1 text-lg font-bold text-gray-900">{{ $food->name }}</h3>
                            <a href="{{ route('toko.show', $food->seller_id) }}" class="mb-3 block text-sm font-medium text-gray-500 transition hover:text-orange-500">
                                Toko: {{ $food->seller->store_name ?? $food->seller->name }}
                            </a>

                            <div class="mb-4">
                                <div class="rounded-xl border border-slate-100 bg-slate-50 px-3 py-2">
                                    <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">Rating Toko</p>
                                    <p class="text-sm font-extrabold text-slate-800">{{ $food->store_avg_rating ? number_format($food->store_avg_rating, 1) : '-' }}/5</p>
                                </div>
                            </div>

                            <div class="mb-4 border-t border-gray-100 pt-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Harga Special</p>
                                <div class="flex items-end gap-2">
                                    <p class="text-2xl font-extrabold text-orange-600">Rp {{ number_format($food->discount_price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-400 line-through">Rp {{ number_format($food->original_price, 0, ',', '.') }}</p>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">Biaya admin tetap Rp {{ number_format(config('resq.customer_admin_fee'), 0, ',', '.') }} akan ditambahkan saat order.</p>
                            </div>

                            <form
                                action="{{ route('order.store', $food->id) }}"
                                method="POST"
                                class="mt-auto"
                                data-confirm-submit
                                data-confirm-title="Pesan makanan ini?"
                                data-confirm-text="Pesanan akan dikirim ke penjual. Pastikan kamu siap pickup tepat waktu."
                                data-confirm-button="Ya, pesan"
                                data-loading-message="Pesanan sedang dikirim ke penjual."
                            >
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <label class="mb-3 flex items-start gap-2 text-xs text-gray-500">
                                    <input type="checkbox" name="accepted_order_terms" value="1" class="mt-0.5 rounded border-gray-300 text-orange-500 focus:ring-orange-500" required>
                                    <span>Setuju <a href="{{ route('terms.customer') }}" class="font-bold text-orange-600">T&C Customer</a> dan siap pickup tepat waktu.</span>
                                </label>
                                <button type="submit" data-loading-text="Mengirim pesanan..." class="w-full rounded-xl bg-orange-500 px-4 py-3 text-white font-bold shadow-sm transition hover:bg-orange-600">
                                    Pesan Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-100">
                        <p class="text-gray-500 font-medium">Belum ada project makanan tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
