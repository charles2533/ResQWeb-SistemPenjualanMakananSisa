<x-guest-layout>
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gradient-to-br from-orange-100 via-amber-50 to-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-full w-full max-w-5xl items-center justify-center">
            <div class="w-full overflow-hidden rounded-[2rem] border border-orange-100 bg-white shadow-2xl shadow-orange-200/40">
                <div class="relative overflow-hidden border-b border-orange-100 bg-gradient-to-r from-orange-500 via-orange-400 to-amber-400 px-8 py-10 text-white">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -bottom-16 left-10 h-32 w-32 rounded-full bg-amber-200/30 blur-2xl"></div>
                    <div class="relative">
                        <p class="mb-2 text-xs font-black uppercase tracking-[0.24em] text-orange-100">Customer Terms</p>
                        <h1 class="text-3xl font-black sm:text-4xl">Terms & Conditions Customer ResQ-Food</h1>
                        <p class="mt-3 max-w-3xl text-sm leading-6 text-orange-50 sm:text-base">
                            Ketentuan ini mengatur kewajiban customer saat memesan makanan rescue, termasuk biaya admin tetap Rp {{ number_format(config('resq.customer_admin_fee'), 0, ',', '.') }}, pickup tepat waktu, dan prosedur komplain kualitas makanan.
                        </p>
                    </div>
                </div>

                <div class="space-y-8 px-8 py-8 text-sm leading-7 text-slate-700 sm:px-10 sm:py-10">
                    <section class="rounded-2xl border border-orange-100 bg-orange-50/50 p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">1. Saat Pesanan Dibuat</h2>
                        <p>Setelah customer menekan tombol pesan, stok makanan langsung dikunci untuk order tersebut. Customer menyetujui total pembayaran yang terdiri dari harga makanan ditambah biaya admin platform sebesar Rp {{ number_format(config('resq.customer_admin_fee'), 0, ',', '.') }} per pesanan.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">2. Kewajiban Pickup</h2>
                        <p>Customer wajib mengambil pesanan sesuai jadwal pickup yang tercantum. Keterlambatan atau ketidakhadiran tanpa konfirmasi dapat menyebabkan pesanan hangus karena makanan sudah disisihkan dan berisiko tidak dapat dijual kembali.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">3. No-Pickup dan Pengembalian Dana</h2>
                        <p>Jika customer tidak datang mengambil makanan, biaya admin platform tetap dianggap terpakai. Pengembalian dana harga makanan, jika ada, menjadi kebijakan seller berdasarkan kondisi makanan dan kebijakan operasional mitra.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">4. Komplain Kualitas Makanan</h2>
                        <p>Jika makanan diterima dalam kondisi basi, rusak, atau tidak sesuai deskripsi, customer wajib mengajukan komplain dengan data order yang valid. Seller bertanggung jawab atas kualitas makanan yang disiapkan, sedangkan ResQ-Food bertindak sebagai fasilitator pencatatan dan evaluasi komplain.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">5. Rating dan Evaluasi</h2>
                        <p>Customer dapat memberikan rating dan ulasan setelah order selesai. Data ini digunakan untuk evaluasi toko dan peningkatan kualitas layanan aplikasi.</p>
                    </section>

                    <div class="flex flex-wrap gap-3 border-t border-orange-100 pt-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600">Kembali ke Registrasi</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-xl bg-orange-100 px-5 py-3 text-sm font-bold text-orange-700 transition hover:bg-orange-200">Masuk ke Dashboard</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
