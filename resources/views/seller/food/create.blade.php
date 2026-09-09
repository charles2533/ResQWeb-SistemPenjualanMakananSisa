<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('seller.inventory') }}" class="text-sm font-semibold text-gray-500 hover:text-orange-500 mb-4 inline-block">&larr; Kembali</a>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Input Makanan Sisa</h1>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form
                    action="{{ route('food.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-8"
                    data-confirm-submit
                    data-confirm-title="Simpan makanan ini?"
                    data-confirm-text="Data makanan akan dipublikasikan ke stok penjualan."
                    data-confirm-button="Ya, simpan"
                    data-loading-message="Makanan sedang disimpan."
                >
                    @csrf
                    
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">1. Informasi Makanan</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Makanan</label>
                                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm text-gray-800" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm text-gray-800"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Upload Foto</label>
                                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 rounded-lg bg-white border border-gray-200 focus:border-orange-500 transition text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-6">2. Harga & Pengambilan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Harga Asli (Rp)</label>
                                <input type="number" name="original_price" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm text-gray-800" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Harga Diskon (Rp)</label>
                                <input type="number" name="discount_price" class="w-full px-4 py-3 rounded-lg bg-orange-50/50 border border-orange-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm text-orange-800 font-bold" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sisa Stok (Porsi)</label>
                                <input type="number" name="stock" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm text-gray-800" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jam Mulai Pickup</label>
                                <input type="time" name="pickup_time_start" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Batas Akhir Pickup</label>
                                <input type="time" name="pickup_time_end" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition text-sm" required>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" data-loading-text="Menyimpan..." class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition">
                            SIMPAN MAKANAN
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
