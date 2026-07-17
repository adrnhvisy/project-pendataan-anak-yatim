<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Master Wilayah</h2>

            <!-- Tombol Pemicu Modal -->
            <button onclick="toggleModal('modal-tambah-wilayah')"
                class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition shadow-sm hover:shadow-md">
                + Tambah Wilayah
            </button>
        </div>
    </x-slot>

    <!-- Konten Utama -->
    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div
                    class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notifikasi Error (Bila penghapusan gagal) -->
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- TABS NAVIGATION -->
            <div class="flex space-x-1 mb-6 bg-white p-1 rounded-xl shadow-sm border border-[#e5eeff] w-fit">
                @foreach(['kelurahan', 'kecamatan', 'kabupaten', 'provinsi'] as $tab)
                    <a href="{{ route('wilayah.index', ['type' => $tab]) }}"
                        class="px-5 py-2.5 rounded-lg text-sm font-semibold transition {{ $type == $tab ? 'bg-[#004ac6] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ ucfirst($tab) }}
                    </a>
                @endforeach
            </div>

            <!-- Tabel Data -->
            <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">

                <!-- TABEL DINAMIS -->
                <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-[#434655]">
                            <thead class="text-xs uppercase bg-[#f1f5f9]">
                                <tr>
                                    @if($type == 'kelurahan')
                                        <th class="px-6 py-4">Nama Kelurahan</th>
                                        <th class="px-6 py-4">Kecamatan</th>
                                        <th class="px-6 py-4">Kode Pos</th>
                                    @elseif($type == 'kecamatan')
                                        <th class="px-6 py-4">Nama Kecamatan</th>
                                        <th class="px-6 py-4">Kabupaten</th>
                                    @elseif($type == 'kabupaten')
                                        <th class="px-6 py-4">Nama Kabupaten</th>
                                        <th class="px-6 py-4">Provinsi</th>
                                    @else
                                        <th class="px-6 py-4">Nama Provinsi</th>
                                    @endif
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e5eeff]">
                                @forelse ($data as $item)
                                    <tr class="hover:bg-blue-50/50 transition">
                                        @if($type == 'kelurahan')
                                            <td class="px-6 py-4 font-bold text-[#0b1c30]">{{ $item->nama_kelurahan }}</td>
                                            <td class="px-6 py-4">{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                                            <td class="px-6 py-4">{{ $item->kode_pos ?? '-' }}</td>
                                        @elseif($type == 'kecamatan')
                                            <td class="px-6 py-4 font-bold text-[#0b1c30]">{{ $item->nama_kecamatan }}</td>
                                            <td class="px-6 py-4">{{ $item->kabupaten->nama_kabupaten ?? '-' }}</td>
                                        @elseif($type == 'kabupaten')
                                            <td class="px-6 py-4 font-bold text-[#0b1c30]">{{ $item->nama_kabupaten }}</td>
                                            <td class="px-6 py-4">{{ $item->provinsi->nama_provinsi ?? '-' }}</td>
                                        @else
                                            <td class="px-6 py-4 font-bold text-[#0b1c30]">{{ $item->nama_provinsi }}</td>
                                        @endif

                                        <td class="px-6 py-4 text-right">
                                            @php
                                                // Logika dinamis untuk menentukan nama route
                                                $editRoute = ($type == 'kelurahan') ? 'wilayah.edit' : "wilayah.{$type}.edit";
                                                $deleteRoute = ($type == 'kelurahan') ? 'wilayah.destroy' : "wilayah.{$type}.destroy";
                                            @endphp

                                            <a href="{{ route($editRoute, $item->id) }}"
                                                class="text-[#004ac6] font-medium hover:underline mr-4">Edit</a>

                                            <form action="{{ route($deleteRoute, $item->id) }}" method="POST"
                                                class="inline form-hapus"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 font-medium hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">Data belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Modal Popup Dipindahkan ke Sini (Luar Header) -->
    <div id="modal-tambah-wilayah" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div onclick="toggleModal('modal-tambah-wilayah')"
                class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity backdrop-blur-sm" aria-hidden="true">
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Konten Modal -->
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-[#0b1c30] mb-2" id="modal-title">
                                Pilih Tingkat Wilayah
                            </h3>
                            <p class="text-sm text-gray-500 mb-5">Tingkat wilayah apa yang ingin Anda tambahkan ke dalam
                                sistem?</p>

                            <div class="space-y-3">
                                <!-- Pilihan 1: Provinsi -->
                                <a href="{{ route('wilayah.provinsi.create') }}"
                                    class="block w-full text-left px-5 py-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-[#004ac6] transition group">
                                    <p class="text-base font-bold text-[#0b1c30] group-hover:text-[#004ac6]">Tambah
                                        Provinsi</p>
                                    <p class="text-xs text-gray-500 mt-1">Tambahkan data provinsi baru ke sistem.</p>
                                </a>

                                <!-- Tambahkan di dalam daftar pilihan modal -->
                                <a href="{{ route('wilayah.kabupaten.create') }}"
                                    class="block w-full text-left px-5 py-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-[#004ac6] transition group">
                                    <p class="text-base font-bold text-[#0b1c30] group-hover:text-[#004ac6]">Tambah
                                        Kabupaten</p>
                                    <p class="text-xs text-gray-500 mt-1">Tambahkan data kabupaten/kota baru.</p>
                                </a>

                                <!-- Pilihan 2: Kecamatan -->
                                <a href="{{ route('wilayah.kecamatan.create') }}"
                                    class="block w-full text-left px-5 py-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-[#004ac6] transition group">
                                    <p class="text-base font-bold text-[#0b1c30] group-hover:text-[#004ac6]">Tambah
                                        Kecamatan</p>
                                    <p class="text-xs text-gray-500 mt-1">Tambahkan kecamatan di bawah suatu
                                        kabupaten/kota.</p>
                                </a>

                                <!-- Pilihan 3: Kelurahan -->
                                <a href="{{ route('wilayah.create') }}"
                                    class="block w-full text-left px-5 py-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-[#004ac6] transition group">
                                    <p class="text-base font-bold text-[#0b1c30] group-hover:text-[#004ac6]">Tambah
                                        Kelurahan / Desa</p>
                                    <p class="text-xs text-gray-500 mt-1">Tambahkan kelurahan di bawah suatu kecamatan.
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                    <button type="button" onclick="toggleModal('modal-tambah-wilayah')"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-100 focus:outline-none sm:mt-0 sm:w-auto transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
        }
    </script>
</x-app-layout>