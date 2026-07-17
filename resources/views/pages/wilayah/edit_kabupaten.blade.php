<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Edit Kabupaten</h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <form action="{{ route('wilayah.kabupaten.update', $wilayah->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Provinsi</label>
                        <select name="provinsi_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                            @foreach($provinsis as $prov)
                                <option value="{{ $prov->id }}" @selected($wilayah->provinsi_id == $prov->id)>
                                    {{ $prov->nama_provinsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kabupaten</label>
                        <input type="text" name="nama_kabupaten" value="{{ old('nama_kabupaten', $wilayah->nama_kabupaten) }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('wilayah.index', ['type' => 'kabupaten']) }}" class="px-4 py-2 text-sm font-medium text-gray-600">Batal</a>
                        <button type="submit" class="px-5 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">Update Kabupaten</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>