<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-8 py-8 bg-emerald-50 border-b border-emerald-100">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600 mb-2">PNC</p>
                    <h1 class="text-3xl font-black text-slate-900">Pemberitahuan Privasi & Consent</h1>
                    <p class="text-sm text-slate-600 mt-3">Akun kamu sudah aktif. Berikut ringkasan penggunaan data dan persetujuan yang berlaku setelah pendaftaran.</p>
                </div>

                <div class="px-8 py-8 space-y-6 text-sm leading-7 text-slate-700">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <p class="font-bold text-slate-900 mb-2">Data yang dipakai platform</p>
                        <p>Nama, email, histori order, rating, dan aktivitas akun digunakan untuk autentikasi, pengelolaan pesanan, evaluasi kualitas mitra, dan ringkasan performa platform.</p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <p class="font-bold text-slate-900 mb-2">Persetujuan yang baru dicatat</p>
                        <p>Kamu telah menyetujui Terms & Conditions serta PNC pada saat registrasi. Persetujuan ini menjadi dasar pemrosesan pesanan, biaya admin, komplain, dan sistem rating.</p>
                    </div>

                    <div class="rounded-2xl border border-orange-100 bg-orange-50 p-5">
                        <p class="font-bold text-slate-900 mb-2">Catatan penting</p>
                        <p>Pastikan pickup dilakukan tepat waktu. Untuk komplain makanan basi atau tidak layak, laporkan menggunakan data pesanan yang selesai agar evaluasi toko bisa ditindaklanjuti.</p>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="{{ route('terms.customer') }}" class="inline-flex items-center rounded-xl bg-slate-100 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-200 transition">Baca Terms & Conditions Customer</a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-xl bg-emerald-500 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-600 transition">Lanjut ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
