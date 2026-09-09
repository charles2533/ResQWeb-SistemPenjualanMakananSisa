<x-guest-layout>
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gradient-to-br from-orange-100 via-amber-50 to-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-full w-full max-w-5xl items-center justify-center">
            <div class="w-full overflow-hidden rounded-[2rem] border border-orange-100 bg-white shadow-2xl shadow-orange-200/40">
                <div class="relative overflow-hidden border-b border-orange-100 bg-gradient-to-r from-orange-500 via-orange-400 to-amber-400 px-8 py-10 text-white">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -bottom-16 left-10 h-32 w-32 rounded-full bg-amber-200/30 blur-2xl"></div>
                    <div class="relative">
                        <p class="mb-2 text-xs font-black uppercase tracking-[0.24em] text-orange-100">Seller Terms</p>
                        <h1 class="text-3xl font-black sm:text-4xl">Terms & Conditions Seller ResQ-Food</h1>
                        <p class="mt-3 max-w-3xl text-sm leading-6 text-orange-50 sm:text-base">
                            Ketentuan ini mengatur hak dan kewajiban seller, termasuk pengelolaan saldo dari order selesai, proses withdraw, dan komisi platform {{ rtrim(rtrim(number_format(config('resq.seller_withdraw_commission_percentage'), 2, '.', ''), '0'), '.') }}% saat penarikan saldo.
                        </p>
                    </div>
                </div>

                <div class="space-y-8 px-8 py-8 text-sm leading-7 text-slate-700 sm:px-10 sm:py-10">
                    <section class="rounded-2xl border border-orange-100 bg-orange-50/50 p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">1. Tanggung Jawab Seller</h2>
                        <p>Seller wajib mengunggah makanan yang masih layak konsumsi, memberikan deskripsi yang jujur, serta memastikan pesanan siap diambil pada slot pickup yang ditampilkan di aplikasi.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">2. Saldo Seller</h2>
                        <p>Nilai makanan yang berhasil dijual akan masuk ke saldo seller setelah order ditandai selesai. Saldo seller merepresentasikan pendapatan kotor seller dari subtotal makanan, tidak termasuk biaya admin customer yang menjadi pendapatan platform.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">3. Withdraw dan Komisi</h2>
                        <p>Seller dapat menarik saldo yang tersedia melalui dashboard seller. Setiap penarikan saldo akan dikenakan komisi platform sebesar {{ rtrim(rtrim(number_format(config('resq.seller_withdraw_commission_percentage'), 2, '.', ''), '0'), '.') }}% dari nominal withdraw. Dana bersih yang diterima seller adalah nominal withdraw setelah dikurangi komisi tersebut.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">4. No-Pickup dan Komplain</h2>
                        <p>Jika customer tidak datang pickup, seller berhak menentukan tindak lanjut terhadap makanan yang tidak diambil. Untuk komplain makanan basi atau tidak layak, seller bertanggung jawab atas mutu produk dan wajib kooperatif dalam proses evaluasi yang difasilitasi platform.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">5. Evaluasi dan Sanksi</h2>
                        <p>ResQ-Food dapat menggunakan histori transaksi, rating, dan catatan komplain untuk evaluasi seller. Pelanggaran berulang dapat menyebabkan peringatan, penurunan visibilitas toko, pembatasan fitur, atau penonaktifan akun seller.</p>
                    </section>

                    <div class="flex flex-wrap gap-3 border-t border-orange-100 pt-4">
                        @auth
                            <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600">Kembali ke Dashboard Seller</a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600">Masuk ke Aplikasi</a>
                        @endauth
                        <a href="{{ route('terms.customer') }}" class="inline-flex items-center rounded-xl bg-orange-100 px-5 py-3 text-sm font-bold text-orange-700 transition hover:bg-orange-200">Lihat T&C Customer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
