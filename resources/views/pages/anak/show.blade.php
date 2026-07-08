<x-app-layout>
    <x-slot name="header">
        @php
            // Logic untuk menentukan kemana arah tombol kembali
            $isFromVerifikasi = request()->query('from') === 'verifikasi';
            $canGoToVerifikasi = auth()->user()->hasRole('kesra');

            $backRoute = ($isFromVerifikasi && $canGoToVerifikasi)
                ? route('verifikasi.index')
                : route('anak.index');
        @endphp

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ $backRoute }}"
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] text-gray-500 shadow-sm hover:bg-[#eff4ff] hover:text-[#004ac6] hover:border-[#004ac6] transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-[#0b1c30] leading-tight">
                        {{ __('Detail Data Anak') }}
                    </h2>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">
                        {{ $isFromVerifikasi ? 'Modul Verifikasi' : 'Modul Data Anak' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @role('pendamping')
                @if(in_array($anak->status_data, ['Ditolak']))
                    <a href="{{ route('anak.edit', $anak->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-[#E2E8F0] rounded-lg font-semibold text-xs text-[#434655] uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                        Edit Data
                    </a>
                    <form action="{{ route('anak.submit', $anak->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" onclick="return confirm('Ajukan data ini untuk verifikasi?')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-sm">
                            Ajukan Verifikasi
                        </button>
                    </form>
                @endif
                @endrole
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-[#EF4444] text-[#EF4444] px-4 py-3 rounded-lg relative">
                    {{ session('error') }}
                </div>
            @endif

            <div
                class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] p-6 flex flex-col md:flex-row items-center md:items-start gap-6">
                
                <div class="flex-1 w-full text-center md:text-left">
                    <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-[#0b1c30]">{{ $anak->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-500 mt-1">No. Registrasi: <span
                                    class="font-medium text-[#0b1c30]">{{ $anak->no_registrasi }}</span></p>
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-wrap justify-center md:justify-end gap-2">
                            <span
                                class="px-4 py-1.5 rounded-full text-xs font-bold bg-[#e5eeff] text-[#004ac6] border border-[#dce9ff]">{{ $anak->status_anak }}</span>
                            @php
                                $statusColor = match ($anak->status_data) {
                                    'Draft' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'Disetujui' => 'bg-green-100 text-green-800 border-green-200',
                                    'Ditolak' => 'bg-red-100 text-red-800 border-red-200',
                                    default => 'bg-gray-100 text-gray-800 border-gray-200'
                                };
                            @endphp
                            <span
                                class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $statusColor }}">{{ $anak->status_data }}</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-5 gap-4 border-t border-[#e5eeff] pt-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">NIK</p>
                            <p class="text-sm font-medium text-[#0b1c30]">{{ $anak->nik }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">No. KK</p>
                            <p class="text-sm font-medium text-[#0b1c30]">{{ $anak->no_kk }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Tempat, Tgl Lahir</p>
                            <p class="text-sm font-medium text-[#0b1c30]">
                                {{ $anak->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Umur</p>
                            <p class="text-sm font-medium text-[#0b1c30]">
                                {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} Tahun
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Jenis Kelamin</p>
                            <p class="text-sm font-medium text-[#0b1c30]">{{ $anak->jenis_kelamin }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                        <h3 class="text-lg font-bold text-[#0b1c30]">Alamat Domisili</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt>
                                <dd class="text-sm text-[#0b1c30] col-span-2">
                                    {{ $anak->alamatDomisili->alamat_lengkap }}
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4">
                                <dt class="text-sm font-medium text-gray-500">RT / RW</dt>
                                <dd class="text-sm text-[#0b1c30] col-span-2">{{ $anak->alamatDomisili->rt }} /
                                    {{ $anak->alamatDomisili->rw }}
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4">
                                <dt class="text-sm font-medium text-gray-500">Kelurahan</dt>
                                <dd class="text-sm text-[#0b1c30] col-span-2">
                                    {{ $anak->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }}
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4">
                                <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                                <dd class="text-sm text-[#0b1c30] col-span-2">
                                    {{ $anak->alamatDomisili->kelurahan->kecamatan->nama_kecamatan ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                        <h3 class="text-lg font-bold text-[#0b1c30]">Catatan Admin Kelurahan</h3>
                    </div>
                    <div class="p-6">
                        @if($anak->catatan)
                            <p class="text-sm text-[#434655] italic bg-yellow-50 p-4 border border-yellow-100 rounded-lg">
                                {{ $anak->catatan }}
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Tidak ada catatan khusus.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden lg:col-span-2">
                    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                        <h3 class="text-lg font-bold text-[#0b1c30]">Informasi Keluarga</h3>
                    </div>
                    <div class="p-0">
                        <div
                            class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-[#e5eeff]">
                            @foreach($anak->orangTua as $ortu)
                                <div class="p-6">
                                    <h4 class="font-bold text-[#004ac6] mb-3 border-b border-gray-100 pb-2">
                                        {{ $ortu->jenis_orang_tua }}
                                    </h4>
                                    <dl class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Nama:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $ortu->nama }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">NIK:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $ortu->nik ?? '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Pekerjaan:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $ortu->pekerjaan ?? '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between mt-2">
                                            <dt class="text-gray-500">Status:</dt>
                                            <dd><span
                                                    class="px-2 py-1 text-xs rounded {{ $ortu->status_hidup == 'Hidup' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $ortu->status_hidup }}</span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            @endforeach

                            <div class="p-6">
                                <h4 class="font-bold text-[#004ac6] mb-3 border-b border-gray-100 pb-2">Wali</h4>
                                @if($anak->wali)
                                    <dl class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Nama:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $anak->wali->nama }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">NIK:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $anak->wali->nik ?? '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Hubungan:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $anak->wali->hubungan_dengan_anak }}
                                            </dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Pekerjaan:</dt>
                                            <dd class="font-medium text-[#0b1c30]">{{ $anak->wali->pekerjaan ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                @else
                                    <p class="text-sm text-gray-500 italic mt-4">Tidak ada data wali terdaftar.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden lg:col-span-2">
                    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                        <h3 class="text-lg font-bold text-[#0b1c30]">Dokumen Anak</h3>
                        <p class="text-sm text-[#737686] mt-1">Daftar dokumen persyaratan yang telah diunggah dan
                            diverifikasi.</p>
                    </div>
                    <div class="p-6">
                        @php
                            $kategoriList = \App\Models\KategoriDokumen::all();
                            $dokumenUpload = $anak->dokumen;
                        @endphp

                        @if($kategoriList->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($kategoriList as $kategori)
                                    @php
                                        $doc = $dokumenUpload->firstWhere('kategori_dok_id', $kategori->id);
                                    @endphp

                                    <div
                                        class="border border-[#e5eeff] rounded-xl p-5 bg-white shadow-sm hover:border-[#004ac6] transition-all duration-200 relative flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start mb-4">
                                                <h4 class="font-bold text-sm text-[#0b1c30] leading-tight">
                                                    {{ $kategori->nama_dokumen }}
                                                </h4>
                                                <span
                                                    class="px-2 py-1 text-[10px] uppercase font-bold rounded-full border {{ $kategori->is_wajib ? 'bg-red-50 text-red-700 border-red-100' : 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                                    {{ $kategori->is_wajib ? 'Wajib' : 'Opsional' }}
                                                </span>
                                            </div>

                                            <div class="space-y-3 mb-6">
                                                @if($doc)
                                                    <div
                                                        class="inline-block px-2 py-1 bg-green-50 text-green-700 text-[10px] font-bold rounded-full border border-green-100 uppercase tracking-wider">
                                                        Sudah Upload</div>
                                                    <div class="text-xs text-[#737686] space-y-1">
                                                        <p class="flex justify-between"><span>Verifikasi:</span> <span
                                                                class="font-semibold {{ $doc->status_verifikasi == 'Valid' ? 'text-green-600' : ($doc->status_verifikasi == 'Tidak Valid' ? 'text-red-600' : 'text-yellow-600') }}">{{ $doc->status_verifikasi ?? '-' }}</span>
                                                        </p>
                                                        <p class="flex justify-between"><span>Tgl Upload:</span> <span
                                                                class="text-[#0b1c30]">{{ $doc->created_at ? $doc->created_at->format('d/m/Y') : '-' }}</span>
                                                        </p>
                                                        <p class="flex justify-between"><span>Catatan:</span> <span
                                                                class="text-[#0b1c30]">{{ $doc->catatan ?? '-' }}</span></p>
                                                        <p class="flex justify-between"><span>Verifikator:</span> <span
                                                                class="text-[#0b1c30]">{{ $doc->verifier->name ?? '-' }}</span></p>
                                                    </div>
                                                @else
                                                    <div
                                                        class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full border border-gray-200 uppercase tracking-wider">
                                                        Belum Upload</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="pt-4 border-t border-[#e5eeff]">
                                            @if($doc && $doc->file_path)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#004ac6] border border-transparent rounded-lg font-semibold text-xs text-white hover:bg-blue-800 transition shadow-sm">
                                                    Lihat Dokumen
                                                </a>
                                            @else
                                                <button disabled
                                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-50 border border-[#E2E8F0] rounded-lg font-semibold text-xs text-[#737686] cursor-not-allowed">
                                                    Belum Ada Dokumen
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#f8f9ff] mb-4">
                                    <svg class="w-8 h-8 text-[#c3c6d7]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-[#737686]">Tidak ada kategori dokumen yang terdaftar.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden lg:col-span-2">
                    <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                        <h3 class="text-lg font-bold text-[#0b1c30]">Histori Verifikasi & Status</h3>
                    </div>
                    <div class="p-6">
                        @if($anak->historiStatus->count() > 0)
                            <div class="relative border-l border-gray-200 ml-3">
                                @foreach($anak->historiStatus as $histori)
                                    <div class="mb-6 ml-6">
                                        <span
                                            class="absolute flex items-center justify-center w-6 h-6 bg-[#e5eeff] rounded-full -left-3 ring-8 ring-white">
                                            <svg class="w-3 h-3 text-[#004ac6]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                        <h4 class="mb-1 text-sm font-semibold text-[#0b1c30]">
                                            {{ $histori->status_baru }}
                                            <span
                                                class="text-xs font-normal text-gray-500 ml-2">{{ $histori->created_at->format('d/m/Y H:i') }}</span>
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ $histori->keterangan }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Oleh:
                                            {{ $histori->pembuatHistori->name ?? 'Sistem' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Belum ada histori status.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>