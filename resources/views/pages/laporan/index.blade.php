<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
            {{ __('Pusat Laporan & Ekspor Data') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kartu Laporan (Tetap) -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff] hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-[#004ac6] rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0b1c30] mb-2">Laporan Data Anak</h3>
                    <p class="text-sm text-[#434655] mb-4">Rekapitulasi seluruh data anak yatim.</p>
                    <a href="{{ route('laporan.anak') }}"
                        class="text-sm font-semibold text-[#004ac6] hover:underline">Lihat Laporan &rarr;</a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff] hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 text-green-700 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#0b1c30] mb-2">Statistik Wilayah</h3>
                    <p class="text-sm text-[#434655] mb-4">Agregasi data jumlah anak yatim berdasarkan wilayah.</p>
                    <a href="{{ route('laporan.wilayah') }}"
                        class="text-sm font-semibold text-[#004ac6] hover:underline">Lihat Laporan &rarr;</a>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('laporan.export') }}" method="POST" id="exportForm" onsubmit="handleExport(this)"
                class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                @csrf
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h3 class="font-bold text-[#0b1c30] text-lg">Export Data</h3>
                    <p class="text-xs text-gray-500">Pilih kriteria dan wilayah data untuk diekspor.</p>
                </div>

                <!-- Pilihan Filter: Diubah jadi 3 kolom (Kriteria, Wilayah, Preview) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <!-- Kolom 1: Kriteria Utama & Tahun -->
                    <div class="space-y-4">
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">Kriteria Data</label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="only_verified" value="1"
                                    class="text-[#004ac6] focus:ring-[#004ac6] rounded">
                                <span class="text-sm text-gray-700 font-medium">Hanya Data Disetujui</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" name="filter" value="all" checked
                                    class="text-[#004ac6] focus:ring-[#004ac6]">
                                <span class="text-sm text-gray-700">Semua Umur</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" name="filter" value="under18"
                                    class="text-[#004ac6] focus:ring-[#004ac6]">
                                <span class="text-sm text-gray-700">
                                    < 18 Tahun</span>
                            </label>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Tahun Dibuat</label>
                            <select name="tahun"
                                class="w-full border border-gray-300 rounded-lg text-sm focus:ring-[#004ac6]">
                                <option value="all">Semua Tahun</option>
                                @for ($i = date('Y'); $i >= 2024; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Kolom 2: Filter Wilayah (Tampil sesuai Role) -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">Wilayah Export</label>

                        @role('kesra|superadmin')
                        <!-- Jika Kesra, bisa pilih Kecamatan -->
                        <div>
                            <select name="kecamatan_id" id="kecamatanSelect" onchange="onKecamatanChange()"
                                class="w-full border border-gray-300 rounded-lg text-sm mb-3 focus:ring-[#004ac6]">
                                <option value="">Semua Kecamatan</option>
                                @foreach($kecamatans as $kec)
                                    <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endrole

                        @role('kesra|kecamatan|superadmin')
                        <!-- Jika Kecamatan/Kesra, bisa pilih Kelurahan -->
                        <div>
                            <select name="kelurahan_id" id="kelurahanSelect" onchange="fetchStatsWilayah()"
                                class="w-full border border-gray-300 rounded-lg text-sm focus:ring-[#004ac6]">
                                <option value="">Semua Kelurahan</option>
                                @if(isset($kelurahans))
                                    @foreach($kelurahans as $kel)
                                        <option value="{{ $kel->id }}">{{ $kel->nama_kelurahan }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @endrole

                        @role('pendamping')
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-800">
                            Anda hanya dapat mengekspor data yang berada di wilayah kelurahan Anda.
                        </div>
                        @endrole
                    </div>

                    <!-- Kolom 3: Preview Statistik -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">Pratinjau Statistik Wilayah</label>
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl relative">
                            <!-- Loading Indicator -->
                            <div id="statsLoading"
                                class="hidden absolute inset-0 bg-white/70 flex items-center justify-center rounded-xl">
                                <span class="text-sm font-semibold text-gray-500">Memuat data...</span>
                            </div>

                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Data Anak</p>
                            <p id="statsTotal" class="text-3xl font-bold text-[#004ac6]">0</p>

                            <div class="mt-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Telah Disetujui</p>
                                <p id="statsDisetujui" class="text-2xl font-bold text-green-600">0</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-3 pt-2 border-t border-gray-100">
                    <button type="submit" name="type" value="excel"
                        class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition disabled:opacity-50">
                        Export Excel
                    </button>
                    <button type="submit" name="type" value="pdf"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition disabled:opacity-50">
                        Export PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchStatsWilayah();
        });

        // Fungsi khusus saat Kecamatan diubah
        function onKecamatanChange() {
            let kelurahanSelect = document.getElementById('kelurahanSelect');

            // Reset pilihan kelurahan kembali ke "Semua Kelurahan"
            if (kelurahanSelect) {
                kelurahanSelect.value = "";
            }

            // Jalankan fetch data
            fetchStatsWilayah(true);
        }

        // Parameter isKecamatanChanged digunakan untuk menentukan apakah dropdown kelurahan perlu di-render ulang
        function fetchStatsWilayah(isKecamatanChanged = false) {
            let kecamatanSelect = document.getElementById('kecamatanSelect');
            let kelurahanSelect = document.getElementById('kelurahanSelect');

            let kecamatanId = kecamatanSelect ? kecamatanSelect.value : '';
            let kelurahanId = kelurahanSelect ? kelurahanSelect.value : '';

            // Tampilkan loading state
            document.getElementById('statsLoading').classList.remove('hidden');

            let url = `{{ route('laporan.get-stats') }}?kecamatan_id=${kecamatanId}&kelurahan_id=${kelurahanId}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update text statistik
                    document.getElementById('statsTotal').innerText = data.total;
                    document.getElementById('statsDisetujui').innerText = data.disetujui;

                    // Render ulang dropdown kelurahan JIKA yang diubah adalah kecamatan
                    if (kelurahanSelect && isKecamatanChanged) {
                        kelurahanSelect.innerHTML = '<option value="">Semua Kelurahan</option>';

                        if (data.kelurahans && data.kelurahans.length > 0) {
                            data.kelurahans.forEach(kel => {
                                kelurahanSelect.innerHTML += `<option value="${kel.id}">${kel.nama_kelurahan}</option>`;
                            });
                        }
                    }

                    // Sembunyikan loading
                    document.getElementById('statsLoading').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error fetching stats:', error);
                    document.getElementById('statsLoading').classList.add('hidden');
                });
        }

        function handleExport(form) {
            const buttons = form.querySelectorAll('button[type="submit"]');

            buttons.forEach(btn => {
                btn.dataset.originalText = btn.innerText;
                btn.innerText = 'Memproses...';
            });

            setTimeout(() => {
                buttons.forEach(btn => {
                    btn.disabled = true;
                });
            }, 100);

            setTimeout(() => {
                buttons.forEach(btn => {
                    btn.disabled = false;
                    btn.innerText = btn.dataset.originalText;
                });
            }, 4000);
        }
    </script>
</x-app-layout>