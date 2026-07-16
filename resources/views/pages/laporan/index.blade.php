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
                    <p class="text-xs text-gray-500">Pilih kriteria data untuk diekspor ke Excel atau PDF.</p>
                </div>

                <!-- Pilihan Filter -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <!-- Kolom 1: Kriteria Utama -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">Kriteria Data</label>
                        <label class="flex items-center space-x-3 cursor-pointer pt-2">
                            <input type="checkbox" name="only_verified" value="1"
                                class="text-[#004ac6] focus:ring-[#004ac6] rounded">
                            <span class="text-sm text-gray-700 font-medium">Hanya Data Disetujui / Terverifikasi</span>
                        </label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="filter" value="all" checked
                                class="text-[#004ac6] focus:ring-[#004ac6]">
                            <span class="text-sm text-gray-700">Export Semua Data</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="filter" value="under18"
                                class="text-[#004ac6] focus:ring-[#004ac6]">
                            <span class="text-sm text-gray-700">Export Anak di bawah 18 Tahun</span>
                        </label>
                    </div>
            
                    <!-- Kolom 2: Pilihan Tahun -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700">Pilih Tahun</label>
                        <select name="tahun"
                            class="w-full border border-gray-300 rounded-lg text-sm focus:ring-[#004ac6] focus:border-[#004ac6]">
                            <option value="all">Semua Tahun</option>
                            @for ($i = date('Y'); $i >= 2024; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-3">
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