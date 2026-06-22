<aside class="w-64 bg-white border-r border-gray-100 min-h-screen hidden md:block">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <div class="flex items-center justify-center mb-8 mt-2">
            <span class="text-xl font-bold text-gray-800 text-center">
                {{ $pengaturan_web['nama_aplikasi'] ?? 'Sistem Anak Yatim' }}
            </span>

            <div class="mt-4 text-xs text-center text-gray-500">
                Hubungi Kami: {{ $pengaturan_web['nomor_kontak'] ?? '-' }}
            </div>
        </div>

        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            @role('superadmin')
            <div class="pt-4 pb-2">
                <span class="text-xs font-bold text-gray-400 uppercase">Menu Superadmin</span>
            </div>

            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path
                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Manajemen User</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul x-show="open" style="display: none;" class="py-2 space-y-2">
                    <li><a href="{{ route('superadmin.users.index') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Daftar
                            Pengguna</a></li>
                    <li><a href="{{ route('superadmin.roles.index') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Role
                            & Hak Akses</a></li>
                </ul>
            </li>

            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Master Data</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul x-show="open" style="display: none;" class="py-2 space-y-2">
                    <li><a href="{{ route('superadmin.wilayah.index') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data
                            Wilayah</a></li>
                    <li><a href="{{ route('superadmin.dokumen.index') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Kategori
                            Dokumen</a></li>
                </ul>
            </li>

            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5 11.424V1a1 1 0 1 0-2 0v10.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.228 3.228 0 0 0 0-6.152ZM19.25 14.5A3.243 3.243 0 0 0 17 11.424V1a1 1 0 0 0-2 0v10.424a3.227 3.227 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.243 3.243 0 0 0 2.25-3.076Zm-6-9A3.243 3.243 0 0 0 11 2.424V1a1 1 0 0 0-2 0v1.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0V8.576A3.243 3.243 0 0 0 13.25 5.5Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Pengaturan</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul x-show="open" style="display: none;" class="py-2 space-y-2">
                    <li><a href="{{ route('superadmin.pengaturan.index') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Konfigurasi
                            Web</a></li>
                    <li><a href="{{ route('superadmin.audit.index') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Log
                            Aktivitas</a></li>
                </ul>
            </li>
            @endrole

            @role('kecamatan')
            <div class="pt-4 pb-2">
                <span class="text-xs font-bold text-gray-400 uppercase">Menu Kecamatan</span>
            </div>

            <li>
                <a href="{{ route('anak.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                        <path
                            d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 1 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                        <path
                            d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Anak Yatim</span>
                </a>
            </li>

            <li>
                <a href="{{ route('anak.laporan') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Laporan Data</span>
                </a>
            </li>
            @endrole

            @role('pendamping')
            <div class="pt-4 pb-2">
                <span class="text-xs font-bold text-gray-400 uppercase">Menu Pendamping</span>
            </div>

            <li><a href="{{ route('anak.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Data Anak</span>
                </a></li>

            <li><a href="{{ route('anak.create') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Input Data Anak</span>
                </a></li>

            <li><a href="{{ route('anak.laporan') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Laporan</span>
                </a></li>
            @endrole

            @role('kesra')
            <div class="pt-4 pb-2">
                <span class="text-xs font-bold text-gray-400 uppercase">Menu Admin Bupati</span>
            </div>

            <li><a href="{{ route('anak.verifikasi') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Antrian Verifikasi</span>
                </a></li>

            <li><a href="{{ route('anak.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Data Anak</span>
                </a></li>

            <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Anggaran</span>
                </a></li>

            <li><a href="{{ route('anak.laporan') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <span class="ms-3">Laporan</span>
                </a></li>
            @endrole

        </ul>
    </div>
</aside>