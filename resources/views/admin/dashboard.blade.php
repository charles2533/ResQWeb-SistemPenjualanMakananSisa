<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ringkasan Ekosistem</h1>
                    <p class="text-sm text-slate-500 mt-1">Pantau status penyelamatan makanan, nilai transaksi, dan pengguna aktif.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Makanan Diselamatkan</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ $foodRescued }} <span class="text-sm font-semibold text-slate-400">porsi</span></h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Nilai Transaksi</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 10v-1m9-4a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pendapatan Admin</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($platformRevenue, 0, ',', '.') }}</h3>
                        <p class="text-xs text-slate-500 mt-1">Fee customer Rp {{ number_format($customerAdminRevenue, 0, ',', '.') }} + komisi seller Rp {{ number_format($sellerCommissionRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Mitra Penjual</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalSellers }} <span class="text-sm font-semibold text-slate-400">toko</span></h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pengguna Terdaftar</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalCustomers }} <span class="text-sm font-semibold text-slate-400">orang</span></h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Rating Aplikasi</p>
                    <h3 class="text-3xl font-black text-slate-900">{{ optional($ratingAverages->get('application'))->avg_rating ? number_format($ratingAverages->get('application')->avg_rating, 1) : '-' }}/5</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ optional($ratingAverages->get('application'))->total_reviews ?? 0 }} review</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Rating Toko</p>
                    <h3 class="text-3xl font-black text-slate-900">{{ optional($ratingAverages->get('store'))->avg_rating ? number_format($ratingAverages->get('store')->avg_rating, 1) : '-' }}/5</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ optional($ratingAverages->get('store'))->total_reviews ?? 0 }} review</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Transaksi Terakhir</h3>
                        <p class="text-sm text-slate-500">Kelola dan pantau semua pesanan masuk di platform.</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">ID Order</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Pembeli</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Toko / Resto</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Item Makanan</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Admin Fee</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-4 px-6 text-sm font-semibold text-blue-600">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-slate-800">{{ $order->customer->name }}</td>
                                    <td class="py-4 px-6 text-sm text-slate-500">{{ $order->food->seller->store_name ?? $order->food->seller->name }}</td>
                                    <td class="py-4 px-6 text-sm text-slate-700">{{ $order->food->name }} <span class="text-slate-400">(x{{ $order->quantity }})</span></td>
                                    <td class="py-4 px-6 text-sm font-semibold text-amber-600">Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-sm">
                                        @if($order->status == 'completed')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-green-50 text-green-600 text-xs font-bold tracking-wide">SELESAI</span>
                                        @elseif($order->status == 'pending')
                                            <span class="inline-flex px-3 py-1 rounded-full bg-yellow-50 text-yellow-600 text-xs font-bold tracking-wide">PROSES</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold tracking-wide">BATAL</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 text-sm">Belum ada transaksi di platform.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
