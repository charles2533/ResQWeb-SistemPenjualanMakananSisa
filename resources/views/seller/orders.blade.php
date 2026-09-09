<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-6 border-b border-gray-100 bg-white">
                    <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Pesanan Masuk (Order Task)</h3>
                    <p class="text-sm text-gray-500 mt-1">Daftar makanan yang akan diambil oleh pembeli (Pahlawan Pangan).</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-100">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">ID Pesanan</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Pembeli</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Item Makanan</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Keuangan</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Ambil</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Status / Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-5 px-6">
                                        <span class="text-sm font-bold text-orange-600">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="py-5 px-6 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">
                                            {{ substr($order->customer->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-800">{{ $order->customer->name }}</span>
                                    </td>
                                    <td class="py-5 px-6">
                                        <p class="text-sm font-bold text-gray-800">{{ $order->food->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $order->quantity }} porsi</p>
                                    </td>
                                    <td class="py-5 px-6 text-sm">
                                        <p class="font-bold text-gray-900">Nilai order: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        <p class="text-gray-500">Pendapatan toko: Rp {{ number_format($order->subtotal_price, 0, ',', '.') }}</p>
                                        <p class="text-orange-600">Biaya admin customer: Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Saldo seller masuk penuh setelah order diselesaikan. Komisi 10% dipotong saat withdraw.</p>
                                    </td>
                                    <td class="py-5 px-6 text-sm text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($order->food->pickup_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($order->food->pickup_time_end)->format('H:i') }}
                                    </td>
                                    <td class="py-5 px-6 text-right">
                                        @if($order->status == 'pending')
                                            <div class="flex items-center justify-end gap-3">
                                                <span class="inline-flex px-3 py-1 rounded-full border border-yellow-200 bg-yellow-50 text-yellow-700 text-xs font-bold tracking-wide">MENUNGGU</span>
                                                
                                                <form
                                                    action="{{ route('order.complete', $order->id) }}"
                                                    method="POST"
                                                    data-confirm-submit
                                                    data-confirm-title="Selesaikan pesanan ini?"
                                                    data-confirm-text="Status pesanan akan diubah menjadi selesai."
                                                    data-confirm-button="Ya, selesaikan"
                                                    data-loading-message="Pesanan sedang diselesaikan."
                                                >
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" data-loading-text="Memproses..." class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold py-1.5 px-3 rounded-lg shadow-sm transition">
                                                        Selesaikan
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($order->status == 'completed')
                                            <span class="inline-flex px-3 py-1 rounded-full border border-green-200 bg-green-50 text-green-700 text-xs font-bold tracking-wide">SELESAI</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-500">Belum ada pesanan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
