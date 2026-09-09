<x-app-layout>
    <div class="py-4 sm:py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm">
                    <span class="font-medium text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Pesanan Saya</h3>
                        <p class="text-sm text-gray-500 mt-1">Monitoring makanan yang harus kamu ambil, total bayar, dan rating setelah pickup selesai.</p>
                    </div>
                    <a href="{{ route('katalog.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold py-2.5 px-5 rounded-lg shadow-sm transition">
                        + Cari Makanan Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-100">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Task ID</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Project Item (Makanan)</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Penjual (Toko)</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Qty</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Keuangan</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Ambil</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition align-top">
                                    <td class="py-5 px-6">
                                        <span class="text-sm font-bold text-orange-600">#TASK-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="py-5 px-6">
                                        <p class="text-sm font-bold text-gray-800">{{ $order->food->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Total akhir Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">
                                                {{ substr($order->food->seller->store_name ?? $order->food->seller->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-700">{{ $order->food->seller->store_name ?? $order->food->seller->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <span class="text-lg font-extrabold text-gray-800">{{ $order->quantity }}</span>
                                    </td>
                                    <td class="py-5 px-6 text-sm text-gray-500 font-medium">
                                        <p>Subtotal: <span class="font-bold text-gray-700">Rp {{ number_format($order->subtotal_price, 0, ',', '.') }}</span></p>
                                        <p>Admin: <span class="font-bold text-orange-600">Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</span></p>
                                        <p>Total: <span class="font-extrabold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                                    </td>
                                    <td class="py-5 px-6 text-sm text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($order->food->pickup_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($order->food->pickup_time_end)->format('H:i') }}
                                    </td>
                                    <td class="py-5 px-6">
                                        @if($order->status == 'pending')
                                            <span class="inline-flex px-3 py-1 rounded-full border border-yellow-200 bg-yellow-50 text-yellow-700 text-xs font-bold tracking-wide">PROSES AMBIL</span>
                                        @elseif($order->status == 'completed')
                                            <span class="inline-flex px-3 py-1 rounded-full border border-green-200 bg-green-50 text-green-700 text-xs font-bold tracking-wide">SELESAI</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-full border border-red-200 bg-red-50 text-red-700 text-xs font-bold tracking-wide">BATAL</span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6">
                                        @php($reviewed = $reviews[$order->id] ?? [])

                                        @if($order->status === 'completed')
                                            <div class="space-y-3 min-w-[240px]">
                                                @foreach(['application' => 'Aplikasi', 'store' => 'Toko'] as $type => $label)
                                                    @if(isset($reviewed[$type]))
                                                        <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-3 text-emerald-700">
                                                            <p class="mb-2 text-[11px] font-bold uppercase tracking-wide text-emerald-500">Rating {{ $label }}</p>
                                                            <div class="mb-2 flex items-center gap-1 text-amber-400">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <svg class="h-5 w-5 {{ $i <= ($reviewed[$type]['rating'] ?? 0) ? 'fill-current' : 'fill-none stroke-current text-emerald-200' }}" viewBox="0 0 24 24" {{ $i <= ($reviewed[$type]['rating'] ?? 0) ? '' : 'stroke-width=1.8' }} aria-hidden="true">
                                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                                    </svg>
                                                                @endfor
                                                                <span class="ml-1 text-xs font-bold text-emerald-700">{{ $reviewed[$type]['rating'] }}/5</span>
                                                            </div>
                                                            @if(!empty($reviewed[$type]['comment']))
                                                                <p class="text-xs leading-5 text-emerald-700/80">{{ $reviewed[$type]['comment'] }}</p>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <form
                                                            action="{{ route('reviews.store', $order) }}"
                                                            method="POST"
                                                            class="rounded-xl border border-slate-100 bg-slate-50 p-3"
                                                            data-confirm-submit
                                                            data-confirm-title="Kirim rating ini?"
                                                            data-confirm-text="Rating yang sudah dikirim akan diproses untuk evaluasi layanan."
                                                            data-confirm-button="Ya, kirim"
                                                            data-loading-message="Rating sedang dikirim."
                                                        >
                                                            @csrf
                                                            <input type="hidden" name="target_type" value="{{ $type }}">
                                                            <label class="block text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-2">Rating {{ $label }}</label>
                                                            <div class="star-rating">
                                                                @for($i = 5; $i >= 1; $i--)
                                                                    <input
                                                                        id="rating-{{ $order->id }}-{{ $type }}-{{ $i }}"
                                                                        type="radio"
                                                                        name="rating"
                                                                        value="{{ $i }}"
                                                                        class="star-rating__input"
                                                                        required
                                                                    >
                                                                    <label for="rating-{{ $order->id }}-{{ $type }}-{{ $i }}" class="star-rating__label" aria-label="{{ $i }} bintang">
                                                                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                                        </svg>
                                                                    </label>
                                                                @endfor
                                                            </div>
                                                            <textarea name="comment" rows="2" class="mt-2 w-full rounded-lg border-slate-200 text-sm" placeholder="Catatan singkat (opsional)"></textarea>
                                                            <button type="submit" data-loading-text="Mengirim..." class="mt-2 w-full rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white hover:bg-slate-800 transition">Kirim Rating</button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-xs text-gray-400">Rating aktif setelah pesanan selesai.</p>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada task pesanan saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
