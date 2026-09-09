<x-guest-layout>
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gradient-to-br from-orange-100 via-amber-50 to-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto flex min-h-full w-full max-w-5xl items-center justify-center">
            <div class="w-full overflow-hidden rounded-[2rem] border border-orange-100 bg-white shadow-2xl shadow-orange-200/40">
                <div class="relative overflow-hidden border-b border-orange-100 bg-gradient-to-r from-orange-500 via-orange-400 to-amber-400 px-8 py-10 text-white">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -bottom-16 left-10 h-32 w-32 rounded-full bg-amber-200/30 blur-2xl"></div>
                    <div class="relative">
                        <p class="mb-2 text-xs font-black uppercase tracking-[0.24em] text-orange-100">Legal</p>
                        <h1 class="text-3xl font-black sm:text-4xl">Terms & Conditions ResQ-Food</h1>
                        <p class="mt-3 max-w-3xl text-sm leading-6 text-orange-50 sm:text-base">
                            Ketentuan ini mengatur tanggung jawab customer, toko, dan platform saat terjadi pemesanan, no-pickup, maupun komplain kualitas makanan.
                        </p>
                    </div>
                </div>

                <div class="space-y-8 px-8 py-8 text-sm leading-7 text-slate-700 sm:px-10 sm:py-10">
                    <section class="rounded-2xl border border-orange-100 bg-orange-50/50 p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">1. Tanggung Jawab Saat Pesanan Dibuat</h2>
                        <p>Setelah customer menyelesaikan pemesanan, stok makanan langsung dikunci untuk order tersebut. Customer wajib melakukan pickup sesuai jadwal yang tercantum pada pesanan.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">2. Jika Pesanan Tidak Di-Pickup</h2>
                        <p>Jika customer tidak hadir pada waktu pickup tanpa konfirmasi, pesanan dapat dinyatakan hangus atau dibatalkan oleh mitra. Dalam kondisi ini, tanggung jawab utama berada pada customer karena slot stok sudah disisihkan dan makanan berisiko tidak dapat dijual kembali.</p>
                        <p class="mt-3">Biaya admin platform tetap dianggap terpakai untuk pemrosesan order. Pengembalian dana, jika diberikan, menjadi kebijakan mitra penjual dan disesuaikan dengan kondisi makanan saat pesanan tidak diambil.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">3. Jika Makanan Basi atau Tidak Layak Konsumsi</h2>
                        <p>Mitra toko wajib memastikan makanan yang diunggah masih layak konsumsi pada saat pickup. Jika makanan diterima dalam kondisi basi, rusak, atau tidak sesuai deskripsi, tanggung jawab utama berada pada pihak toko sebagai pihak yang menyiapkan barang.</p>
                        <p class="mt-3">Platform ResQ-Food bertindak sebagai perantara transaksi dan fasilitator penyaluran makanan. Platform membantu pencatatan komplain dan evaluasi, tetapi tidak menggantikan tanggung jawab mutu produk yang berada pada pihak toko.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">4. Tuntutan dan Penyelesaian Komplain</h2>
                        <p>Setiap komplain harus diajukan dengan data pesanan yang valid. ResQ-Food dapat menggunakan rating, catatan review, dan histori transaksi sebagai dasar evaluasi mitra. Jika ditemukan pelanggaran berulang, platform berhak menurunkan visibilitas toko, memberi peringatan, atau menonaktifkan akun mitra.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">5. Biaya Admin</h2>
                        <p>Setiap transaksi dapat dikenakan biaya admin platform. Biaya ini ditampilkan secara transparan pada ringkasan pesanan sebelum dan sesudah order dibuat.</p>
                    </section>

                    <section class="rounded-2xl border border-slate-100 bg-white p-6">
                        <h2 class="mb-3 text-lg font-extrabold text-slate-900">6. Rating dan Umpan Balik</h2>
                        <p>Customer dapat memberi rating untuk aplikasi dan toko setelah pesanan selesai. Data rating digunakan untuk peningkatan layanan, evaluasi kualitas mitra, dan kebutuhan analisis lean canvas.</p>
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
