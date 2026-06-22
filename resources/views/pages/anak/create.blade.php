<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Pendaftaran Anak Baru</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6" x-data="{ tab: 'biodata' }">
        <div class="flex space-x-4 mb-6 border-b">
            <button @click="tab = 'biodata'" :class="tab === 'biodata' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="px-4 py-2 font-medium">1. Biodata</button>
            <button @click="tab = 'keluarga'" :class="tab === 'keluarga' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="px-4 py-2 font-medium">2. Keluarga</button>
            <button @click="tab = 'dokumen'" :class="tab === 'dokumen' ? 'border-b-2 border-blue-600 text-blue-600' : ''" class="px-4 py-2 font-medium">3. Dokumen</button>
        </div>

        <form action="{{ route('anak.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div x-show="tab === 'biodata'" class="p-6 bg-white shadow rounded-xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-text-input name="nama_lengkap" placeholder="Nama Lengkap" required />
                    <x-text-input name="nik" placeholder="NIK" required />
                    <x-text-input name="no_kk" placeholder="No KK" required />
                    <x-text-input name="no_rekening" placeholder="No Rekening" />
                    <x-text-input name="tempat_lahir" placeholder="Tempat Lahir" required />
                    <x-text-input name="tanggal_lahir" type="date" required />
                    <select name="jenis_kelamin" class="border-gray-300 rounded-md">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <select name="status_anak" class="border-gray-300 rounded-md">
                        <option value="Yatim">Yatim</option>
                        <option value="Piatu">Piatu</option>
                        <option value="Yatim Piatu">Yatim Piatu</option>
                    </select>
                </div>
            </div>

            <div x-show="tab === 'keluarga'" class="p-6 bg-white shadow rounded-xl">
                <h3 class="font-bold mb-4">Data Domisili</h3>
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="col-span-3"><x-text-input name="alamat_lengkap" placeholder="Alamat Lengkap" class="w-full" required /></div>
                    <x-text-input name="rt" placeholder="RT" />
                    <x-text-input name="rw" placeholder="RW" />
                    <select name="kelurahan_id" class="border-gray-300 rounded-md">
                        @foreach($kelurahans as $kel)<option value="{{ $kel->id }}">{{ $kel->nama_kelurahan }}</option>@endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-bold mb-2">Data Ayah</h4>
                        <x-text-input name="nama_ayah" placeholder="Nama Ayah" class="w-full mb-2" required />
                        <x-text-input name="nik_ayah" placeholder="NIK Ayah" class="w-full mb-2" />
                        <select name="status_hidup_ayah" class="w-full border-gray-300 rounded-md"><option value="Hidup">Hidup</option><option value="Meninggal">Meninggal</option></select>
                    </div>
                    <div>
                        <h4 class="font-bold mb-2">Data Ibu</h4>
                        <x-text-input name="nama_ibu" placeholder="Nama Ibu" class="w-full mb-2" required />
                        <x-text-input name="nik_ibu" placeholder="NIK Ibu" class="w-full mb-2" />
                        <select name="status_hidup_ibu" class="w-full border-gray-300 rounded-md"><option value="Hidup">Hidup</option><option value="Meninggal">Meninggal</option></select>
                    </div>
                </div>
            </div>

            <div x-show="tab === 'dokumen'" class="p-6 bg-white shadow rounded-xl">
                <h3 class="font-bold mb-4">Upload Dokumen Pendukung</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label value="Upload Kartu Keluarga (KK)" />
                        <input type="file" name="file_kk" class="block w-full text-sm text-gray-500 border rounded-lg p-2">
                    </div>
                    <div>
                        <x-input-label value="Upload KTP (Jika Ada)" />
                        <input type="file" name="file_ktp" class="block w-full text-sm text-gray-500 border rounded-lg p-2">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <x-primary-button>Simpan Semua Data</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>