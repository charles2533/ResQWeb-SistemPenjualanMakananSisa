<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-6 py-4 text-green-700 shadow-sm">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-6 py-4 text-red-700 shadow-sm">
                    <span class="text-sm font-medium">{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="mb-8 overflow-hidden rounded-[2rem] border border-orange-100 bg-white shadow-xl shadow-orange-100/50">
                <div class="relative overflow-hidden bg-gradient-to-r from-orange-500 via-orange-400 to-amber-400 px-8 py-10 text-white">
                    <div class="absolute -right-8 -top-8 h-36 w-36 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 h-28 w-28 rounded-full bg-amber-200/20 blur-2xl"></div>
                    <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <p class="mb-2 text-xs font-black uppercase tracking-[0.24em] text-orange-100">Seller Finance</p>
                            <h1 class="text-3xl font-black tracking-tight sm:text-4xl">Dashboard Keuangan {{ $seller->store_name ?? $seller->name }}</h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-orange-50 sm:text-base">Pantau saldo seller, total penjualan yang sudah selesai, dan proses withdraw dengan komisi platform {{ rtrim(rtrim(number_format($withdrawCommissionRate, 2, '.', ''), '0'), '.') }}%.</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-wide text-orange-100">Saldo</p>
                                <p class="mt-1 text-xl font-black">Rp {{ number_format($stats['available_balance'], 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-wide text-orange-100">Order Selesai</p>
                                <p class="mt-1 text-xl font-black">{{ $stats['completed_orders'] }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-wide text-orange-100">Order Pending</p>
                                <p class="mt-1 text-xl font-black">{{ $stats['pending_orders'] }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                                <p class="text-[11px] font-bold uppercase tracking-wide text-orange-100">Withdraw Bersih</p>
                                <p class="mt-1 text-xl font-black">Rp {{ number_format($stats['net_withdrawn'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-3">
                    <div class="mb-5 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Ringkasan Saldo</p>
                            <h2 class="mt-1 text-2xl font-black text-slate-900">Siap Ditarik Kapan Saja</h2>
                        </div>
                        <a href="{{ route('seller.inventory') }}" class="inline-flex items-center rounded-xl bg-orange-100 px-4 py-2 text-sm font-bold text-orange-700 transition hover:bg-orange-200">Kelola Stok</a>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-2xl border border-orange-100 bg-orange-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-orange-500">Saldo Aktif</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">Rp {{ number_format($stats['available_balance'], 0, ',', '.') }}</p>
                            <p class="mt-2 text-sm text-slate-600">Saldo ini berasal dari order seller yang statusnya sudah selesai.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Penjualan Masuk</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">Rp {{ number_format($stats['gross_sales'], 0, ',', '.') }}</p>
                            <p class="mt-2 text-sm text-slate-600">Akumulasi pendapatan kotor seller dari seluruh order selesai.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Komisi Platform Dibayar</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">Rp {{ number_format($stats['commission_paid'], 0, ',', '.') }}</p>
                            <p class="mt-2 text-sm text-slate-600">Komisi 10% dipotong saat seller melakukan withdraw saldo.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Withdraw Saldo</p>
                    <h2 class="mt-1 text-2xl font-black text-slate-900">Tarik Dana Seller</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Masukkan nominal saldo yang ingin ditarik. Platform akan mengenakan komisi {{ rtrim(rtrim(number_format($withdrawCommissionRate, 2, '.', ''), '0'), '.') }}% pada saat pencairan.</p>

                    <div class="mt-5 rounded-2xl border border-orange-100 bg-orange-50 p-4 text-sm text-slate-700">
                        <p>Estimasi komisi: <span class="font-bold text-orange-600">Rp {{ number_format($estimatedCommission, 0, ',', '.') }}</span></p>
                        <p class="mt-1">Estimasi dana bersih jika tarik semua saldo: <span class="font-bold text-slate-900">Rp {{ number_format($estimatedNet, 0, ',', '.') }}</span></p>
                    </div>

                    <form action="{{ route('seller.withdraw') }}" method="POST" class="mt-5 space-y-4">
                        @csrf
                        <div>
                            <label for="amount" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-400">Nominal Withdraw</label>
                            <input id="amount" type="number" name="amount" min="1000" max="{{ (int) $stats['available_balance'] }}" step="1000" value="{{ (int) $stats['available_balance'] }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-orange-500 px-4 py-3 text-sm font-bold text-white shadow-md transition hover:bg-orange-600">
                            Proses Withdraw
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-6 py-5">
                        <h3 class="text-lg font-bold text-slate-800">Order Selesai Terbaru</h3>
                        <p class="text-sm text-slate-500">Order yang sudah menambah saldo seller.</p>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($recentOrders as $order)
                            <div class="flex items-start justify-between gap-4 px-6 py-5">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $order->food->name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $order->customer->name }} • Qty {{ $order->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-extrabold text-orange-600">Rp {{ number_format($order->subtotal_price, 0, ',', '.') }}</p>
                                    <p class="mt-1 text-xs text-slate-400">Saldo masuk</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-slate-500">Belum ada order selesai yang menambah saldo seller.</div>
                        @endforelse
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-6 py-5">
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Withdraw</h3>
                        <p class="text-sm text-slate-500">Komisi platform dicatat setiap kali seller menarik saldo.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="bg-slate-50/70">
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Tanggal</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Saldo Ditarik</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Komisi</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Dana Bersih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($withdrawals as $withdrawal)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ optional($withdrawal->processed_at)->format('d M Y H:i') ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">Rp {{ number_format($withdrawal->gross_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-orange-600">Rp {{ number_format($withdrawal->commission_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-green-600">Rp {{ number_format($withdrawal->net_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada withdraw yang diproses.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
