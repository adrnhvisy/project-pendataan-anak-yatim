<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit Data Anak: {{ $anak->nama_lengkap }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="p-6 bg-white shadow-sm rounded-xl border border-gray-100">
            <form action="{{ route('anak.update', $anak->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-full">
                        <h3 class="font-bold text-lg mb-4 text-gray-700">Biodata Anak</h3>
                    </div>
                    
                    <div>
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap', $anak->nama_lengkap) }}" class="block w-full mt-1" required />
                    </div>

                    <div>
                        <x-input-label for="nik" value="NIK" />
                        <x-text-input id="nik" name="nik" type="text" value="{{ old('nik', $anak->nik) }}" class="block w-full mt-1" required />
                    </div>

                    <div class="col-span-full mt-4">
                        <h3 class="font-bold text-lg mb-4 text-gray-700">Alamat</h3>
                    </div>
                    
                    <div class="col-span-full">
                        <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
                        <x-text-input id="alamat_lengkap" name="alamat_lengkap" type="text" value="{{ old('alamat_lengkap', $anak->alamat_domisili->alamat_lengkap) }}" class="block w-full mt-1" required />
                    </div>

                    <div class="col-span-full mt-4">
                        <h3 class="font-bold text-lg mb-4 text-gray-700">Data Ayah</h3>
                    </div>
                    
                    <div>
                        <x-input-label for="nama_ayah" value="Nama Ayah" />
                        <x-text-input id="nama_ayah" name="nama_ayah" type="text" value="{{ old('nama_ayah', $anak->orang_tua->where('jenis_orang_tua', 'Ayah')->first()?->nama) }}" class="block w-full mt-1" />
                    </div>
                    
                    <div>
                        <x-input-label for="status_hidup_ayah" value="Status Ayah" />
                        <select name="status_hidup_ayah" class="block w-full mt-1 border-gray-300 rounded-md">
                            <option value="Hidup" {{ $anak->orang_tua->where('jenis_orang_tua', 'Ayah')->first()?->status_hidup == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="Meninggal" {{ $anak->orang_tua->where('jenis_orang_tua', 'Ayah')->first()?->status_hidup == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end pt-6 mt-6 border-t">
                    <a href="{{ route('anak.index') }}" class="mr-4 px-4 py-2 text-gray-600">Batal</a>
                    <x-primary-button>Update Data</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>