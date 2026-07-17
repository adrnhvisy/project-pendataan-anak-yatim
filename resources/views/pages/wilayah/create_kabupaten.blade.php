<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Tambah Data Kabupaten</h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff] p-6">
                <form action="{{ route('wilayah.kabupaten.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Provinsi</label>
                        <select name="provinsi_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                            <option value="" disabled selected>-- Pilih Provinsi --</option>
                            @foreach($provinsis as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kabupaten</label>
                        <input type="text" name="nama_kabupaten" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]" placeholder="Contoh: Pelalawan">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('wilayah.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600">Batal</a>
                        <button type="submit" class="px-5 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">Simpan Kabupaten</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>