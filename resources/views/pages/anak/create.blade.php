<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Pendaftaran Anak Baru</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <form action="{{ route('anak.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Biodata Anak -->
            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">1. Biodata Anak</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text"
                            value="{{ old('nama_lengkap') }}" class="block w-full mt-1" required />
                    </div>
                    <div>
                        <x-input-label for="nik" value="NIK (16 Digit)" />
                        <x-text-input id="nik" name="nik" type="text" value="{{ old('nik') }}" class="block w-full mt-1"
                            required />
                    </div>
                    <div>
                        <x-input-label for="no_kk" value="Nomor Kartu Keluarga" />
                        <x-text-input id="no_kk" name="no_kk" type="text" value="{{ old('no_kk') }}"
                            class="block w-full mt-1" required />
                    </div>
                    <div>
                        <x-input-label for="no_rekening" value="Nomor Rekening" />
                        <x-text-input id="no_rekening" name="no_rekening" type="text" value="{{ old('no_rekening') }}"
                            class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                        <x-text-input id="tempat_lahir" name="tempat_lahir" type="text"
                            value="{{ old('tempat_lahir') }}" class="block w-full mt-1" required />
                    </div>
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date"
                            value="{{ old('tanggal_lahir') }}" class="block w-full mt-1" required />
                    </div>
                    <div>
                        <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                        <select name="jenis_kelamin" class="block w-full mt-1 border-gray-300 rounded-md">
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="status_anak" value="Status Anak" />
                        <select name="status_anak" class="block w-full mt-1 border-gray-300 rounded-md">
                            <option value="Yatim" {{ old('status_anak') == 'Yatim' ? 'selected' : '' }}>Yatim</option>
                            <option value="Piatu" {{ old('status_anak') == 'Piatu' ? 'selected' : '' }}>Piatu</option>
                            <option value="Yatim Piatu" {{ old('status_anak') == 'Yatim Piatu' ? 'selected' : '' }}>Yatim
                                Piatu</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2. Lokasi Domisili -->
            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">2. Lokasi Domisili</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-3">
                        <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
                        <x-text-input id="alamat_lengkap" name="alamat_lengkap" type="text"
                            value="{{ old('alamat_lengkap') }}" class="w-full mt-1" required />
                    </div>
                    <div>
                        <x-input-label for="rt" value="RT" />
                        <x-text-input id="rt" name="rt" type="text" value="{{ old('rt') }}" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-input-label for="rw" value="RW" />
                        <x-text-input id="rw" name="rw" type="text" value="{{ old('rw') }}" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-input-label for="kelurahan_id" value="Kelurahan" />
                        <select name="kelurahan_id" class="block w-full mt-1 border-gray-300 rounded-md">
                            @foreach($kelurahans as $kel)
                                <option value="{{ $kel->id }}" {{ old('kelurahan_id') == $kel->id ? 'selected' : '' }}>
                                    {{ $kel->nama_kelurahan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Data Ayah</h3>
                    <x-text-input name="nama_ayah" placeholder="Nama Ayah" class="w-full mb-2" required />
                    <x-text-input name="nik_ayah" placeholder="NIK Ayah" class="w-full mb-2" />
                    <select name="status_hidup_ayah" class="w-full border-gray-300 rounded-md">
                        <option value="Hidup">Hidup</option>
                        <option value="Meninggal">Meninggal</option>
                    </select>
                </div>

                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Data Ibu</h3>
                    <x-text-input name="nama_ibu" placeholder="Nama Ibu" class="w-full mb-2" required />
                    <x-text-input name="nik_ibu" placeholder="NIK Ibu" class="w-full mb-2" />
                    <select name="status_hidup_ibu" class="w-full border-gray-300 rounded-md">
                        <option value="Hidup">Hidup</option>
                        <option value="Meninggal">Meninggal</option>
                    </select>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <h3 class="font-bold text-lg mb-4 text-gray-700">Data Wali (Opsional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-text-input name="nama_wali" placeholder="Nama Wali" />
                    <x-text-input name="hubungan_wali" placeholder="Hubungan (Contoh: Paman)" />
                    <x-text-input name="nik_wali" placeholder="NIK Wali" />
                </div>
            </div>

            <div class="flex justify-end">
                <x-primary-button>Simpan Data Anak</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>