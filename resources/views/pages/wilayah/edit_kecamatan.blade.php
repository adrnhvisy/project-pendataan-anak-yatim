<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Edit Kecamatan</h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <form action="{{ route('wilayah.kecamatan.update', $wilayah->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Kabupaten / Kota</label>
                        <select name="kabupaten_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                            @foreach($kabupatens as $kab)
                                <option value="{{ $kab->id }}" @selected($wilayah->kabupaten_id == $kab->id)>
                                    {{ $kab->nama_kabupaten }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kecamatan</label>
                        <input type="text" name="nama_kecamatan" value="{{ old('nama_kecamatan', $wilayah->nama_kecamatan) }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('wilayah.index', ['type' => 'kecamatan']) }}" class="px-4 py-2 text-sm font-medium text-gray-600">Batal</a>
                        <button type="submit" class="px-5 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">Update Kecamatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>