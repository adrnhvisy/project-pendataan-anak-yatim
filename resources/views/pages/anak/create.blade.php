<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Pendaftaran Anak Baru</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <form action="{{ route('anak.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">1. Biodata Anak</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-text-input name="nama_lengkap" placeholder="Nama Lengkap" required />
                    <x-text-input name="nik" placeholder="NIK" required />
                    <x-text-input name="no_kk" placeholder="Nomor KK" required />
                    <x-text-input name="tempat_lahir" placeholder="Tempat Lahir" required />
                    <x-text-input name="tanggal_lahir" type="date" required />
                    <select name="jenis_kelamin" class="border-gray-300 rounded-md">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">2. Lokasi Domisili</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-3">
                        <x-text-input name="alamat_lengkap" placeholder="Alamat Lengkap" class="w-full" required />
                    </div>
                    <x-text-input name="rt" placeholder="RT" />
                    <x-text-input name="rw" placeholder="RW" />
                    <select name="kelurahan_id" class="border-gray-300 rounded-md">
                        @foreach($kelurahans as $kel)
                            <option value="{{ $kel->id }}">{{ $kel->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">3. Data Ayah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-text-input name="nama_ayah" placeholder="Nama Ayah" required />
                    <x-text-input name="nik_ayah" placeholder="NIK Ayah" />
                    <select name="status_hidup_ayah" class="border-gray-300 rounded-md">
                        <option value="Hidup">Hidup</option>
                        <option value="Meninggal">Meninggal</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <x-primary-button>Simpan Data Anak</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>