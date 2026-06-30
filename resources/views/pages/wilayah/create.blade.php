<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Tambah Kelurahan</h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('wilayah.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-[#0b1c30]">Kecamatan</label>
                        <select name="kecamatan_id" class="w-full mt-1 border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6]" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }} ({{ $kec->kabupaten->nama_kabupaten }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#0b1c30]">Nama Kelurahan</label>
                        <input type="text" name="nama_kelurahan" class="w-full mt-1 border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#0b1c30]">Kode Pos</label>
                        <input type="text" name="kode_pos" class="w-full mt-1 border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6]">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('wilayah.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>