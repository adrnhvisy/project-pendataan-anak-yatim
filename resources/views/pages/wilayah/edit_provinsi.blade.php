<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Edit Provinsi</h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <form action="{{ route('wilayah.provinsi.update', $wilayah->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Wajib untuk proses Update -->
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Provinsi</label>
                        <input type="text" name="nama_provinsi" value="{{ old('nama_provinsi', $wilayah->nama_provinsi) }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('wilayah.index', ['type' => 'provinsi']) }}" class="px-4 py-2 text-sm font-medium text-gray-600">Batal</a>
                        <button type="submit" class="px-5 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">Update Provinsi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>