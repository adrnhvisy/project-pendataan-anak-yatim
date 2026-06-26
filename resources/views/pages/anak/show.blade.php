<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Data: {{ $anak->nama_lengkap }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. Informasi Anak & Foto -->
            <div class="bg-white shadow rounded-lg p-6 flex items-start space-x-6">
                @if($anak->foto_path)
                    <img src="{{ asset('storage/' . $anak->foto_path) }}" class="w-32 h-32 object-cover rounded-lg">
                @else
                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">No Photo</div>
                @endif
                <div>
                    <h3 class="text-2xl font-bold">{{ $anak->nama_lengkap }}</h3>
                    <p class="text-gray-600">No. Registrasi: {{ $anak->no_registrasi }} | Status: {{ $anak->status_data }}</p>
                    <p class="mt-2 text-sm text-gray-700">NIK: {{ $anak->nik }} | KK: {{ $anak->no_kk }}</p>
                </div>
            </div>

            <!-- 2. Grid Data Utama -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Orang Tua -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="font-bold text-lg mb-4 border-b pb-2">Informasi Orang Tua</h4>
                    @foreach($anak->orang_tua as $ortu)
                        <div class="mb-3">
                            <p class="text-sm font-semibold text-blue-600">{{ $ortu->jenis_orang_tua }}</p>
                            <p>{{ $ortu->nama }} ({{ $ortu->status_hidup }})</p>
                        </div>
                    @endforeach
                </div>

                <!-- Informasi Wali -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="font-bold text-lg mb-4 border-b pb-2">Informasi Wali</h4>
                    @if($anak->wali->count() > 0)
                        @foreach($anak->wali as $wali)
                            <p>{{ $wali->nama }} ({{ $wali->hubungan_dengan_anak }})</p>
                        @endforeach
                    @else
                        <p class="text-gray-500 italic">Tidak ada wali terdaftar.</p>
                    @endif
                </div>
            </div>

            <!-- 3. Catatan & Dokumen -->
            <div class="bg-white shadow rounded-lg p-6">
                <h4 class="font-bold text-lg mb-4 border-b pb-2">Catatan Admin Kelurahan</h4>
                <p class="text-gray-700 italic bg-gray-50 p-4 rounded">{{ $anak->catatan ?? 'Tidak ada catatan.' }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h4 class="font-bold text-lg mb-4 border-b pb-2">Dokumen Terlampir</h4>
                <div class="flex space-x-4">
                    @foreach($anak->dokumen as $dok)
                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank" class="px-4 py-2 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                            Lihat Dokumen
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>