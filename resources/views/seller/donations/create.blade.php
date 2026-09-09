<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-3 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-6">
                    <a href="{{ route('seller.donations') }}" class="mb-4 inline-block text-sm font-semibold text-gray-500 hover:text-orange-500">&larr; Kembali ke Donasi</a>
                    <h3 class="text-2xl font-extrabold tracking-tight text-gray-900">Tambah Donasi ke Bank Makanan</h3>
                    <p class="mt-1 text-sm text-gray-500">Isi data makanan yang ingin didonasikan tanpa harga jual.</p>
                </div>

                <form
                    action="{{ route('seller.donations.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6 p-6"
                    data-confirm-submit
                    data-confirm-title="Simpan data donasi?"
                    data-confirm-text="Data donasi akan masuk ke daftar penyaluran bank makanan."
                    data-confirm-button="Ya, simpan"
                    data-loading-message="Data donasi sedang disimpan."
                >
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-wide text-slate-400">Nama Makanan</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-wide text-slate-400">Jumlah Porsi</label>
                            <input type="number" name="stock" value="{{ old('stock', 1) }}" min="1" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200" required>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-wide text-slate-400">Detail Donasi</label>
                        <textarea name="description" rows="4" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-wide text-slate-400">Foto</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:font-semibold file:text-orange-600 hover:file:bg-orange-100">
                    </div>

                    <button type="submit" data-loading-text="Menyimpan..." class="rounded-xl bg-orange-500 px-8 py-3 text-sm font-bold text-white shadow-md transition hover:bg-orange-600">
                        Simpan Donasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
