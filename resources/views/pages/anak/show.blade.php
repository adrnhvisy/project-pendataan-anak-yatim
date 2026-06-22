<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                Detail Profil Anak Yatim
            </h2>
            <a href="{{ route('anak.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">
        
        <!-- Header Profil Singkat -->
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex flex-col items-start justify-between md:flex-row md:items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $anak->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-500 font-mono mt-1">No. Registrasi: {{ $anak->no_registrasi }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $anak->status_data == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                          ($anak->status_data == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        Status: {{ $anak->status_data }}
                    </span>
                    
                    <!-- Tombol Aksi Verifikasi untuk Kecamatan -->
                    @role('kesra')
                        @if($anak->status_data == 'Pending')
                        <button class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Verifikasi Data Ini
                        </button>
                        @endif
                    @endrole
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            
            <!-- Kolom Kiri: Informasi Utama (Mengambil 2 kolom di layar besar) -->
            <div class="space-y-6 lg:col-span-2">
                
                <!-- Card Biodata -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 border-b pb-2">Informasi Biodata</h4>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Induk Kependudukan (NIK)</p>
                            <p class="font-medium text-gray-900">{{ $anak->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Kartu Keluarga (KK)</p>
                            <p class="font-medium text-gray-900">{{ $anak->no_kk }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-medium text-gray-900">{{ $anak->tempat_lahir }}, {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p class="font-medium text-gray-900">{{ $anak->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Anak</p>
                            <p class="font-medium text-gray-900">{{ $anak->status_anak }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Alamat -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 border-b pb-2">Alamat Domisili</h4>
                    <p class="font-medium text-gray-900">{{ $anak->alamat_domisili->alamat_lengkap ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        RT {{ $anak->alamat_domisili->rt ?? '-' }} / RW {{ $anak->alamat_domisili->rw ?? '-' }}, 
                        Kelurahan {{ $anak->kelurahan->nama_kelurahan ?? '-' }}
                    </p>
                </div>

                <!-- Card Data Orang Tua -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 border-b pb-2">Data Orang Tua</h4>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @forelse($anak->orang_tua as $ortu)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-100">
                                <span class="text-xs font-bold tracking-wider text-indigo-600 uppercase">{{ $ortu->jenis_orang_tua }}</span>
                                <p class="mt-2 font-semibold text-gray-900">{{ $ortu->nama }}</p>
                                <p class="text-sm text-gray-600">NIK: {{ $ortu->nik }}</p>
                                <p class="mt-2 text-sm">
                                    Status: <span class="font-medium {{ $ortu->status_hidup == 'Meninggal' ? 'text-red-600' : 'text-green-600' }}">{{ $ortu->status_hidup }}</span>
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">Data orang tua belum diinput.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Dokumen & Histori -->
            <div class="space-y-6 lg:col-span-1">
                
                <!-- Card Dokumen -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <div class="flex items-center justify-between mb-4 border-b pb-2">
                        <h4 class="text-lg font-semibold text-gray-800">Dokumen Berkas</h4>
                        <a href="{{ route('anak.dokumen', $anak->id) }}" class="text-xs font-medium text-blue-600 hover:underline">Kelola</a>
                    </div>
                    
                    <ul class="space-y-3">
                        @forelse($anak->dokumen_anak ?? [] as $dokumen)
                        <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 border border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $dokumen->kategori_dokumen->nama_dokumen ?? 'Dokumen' }}</p>
                                <p class="text-xs {{ $dokumen->status_verifikasi == 'Valid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $dokumen->status_verifikasi }}
                                </p>
                            </div>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="p-2 text-gray-500 bg-white rounded-md shadow-sm hover:text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </li>
                        @empty
                        <li class="text-sm text-center text-gray-500">Belum ada dokumen yang diunggah.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Card Histori -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 border-b pb-2">Jejak Status</h4>
                    <div class="relative pl-4 space-y-6 border-l-2 border-gray-100">
                        @forelse($anak->histori_status ?? [] as $histori)
                        <div class="relative">
                            <div class="absolute w-3 h-3 bg-indigo-500 rounded-full -left-[23px] top-1.5"></div>
                            <p class="text-sm font-semibold text-gray-900">{{ $histori->status_anak }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($histori->tanggal)->format('d M Y, H:i') }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $histori->keterangan }}</p>
                            <p class="text-xs italic text-gray-400 mt-1">Oleh: {{ $histori->pembuat_histori->name ?? 'Sistem' }}</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada histori.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>