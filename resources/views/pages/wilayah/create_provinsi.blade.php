<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
            Tambah Data Provinsi
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="p-6 bg-white">
                    
                    <!-- Form mengarah ke route 'wilayah.provinsi.store' dengan metode POST -->
                    <form action="{{ route('wilayah.provinsi.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="nama_provinsi" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Provinsi
                            </label>
                            <input type="text" name="nama_provinsi" id="nama_provinsi" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6] sm:text-sm"
                                placeholder="Contoh: Sumatera Barat">
                            
                            <!-- Menampilkan pesan error validasi jika ada -->
                            @error('nama_provinsi')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#e5eeff]">
                            <a href="{{ route('wilayah.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition shadow-sm">
                                Simpan Provinsi
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>