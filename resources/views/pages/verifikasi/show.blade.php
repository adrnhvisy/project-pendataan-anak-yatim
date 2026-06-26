<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <a href="{{ route('verifikasi.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Periksa Data: {{ $anak->nama_lengkap }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold border-b pb-2 mb-4">Biodata Anak</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500 block">NIK:</span> {{ $anak->nik }}</div>
                    <div><span class="text-gray-500 block">No KK:</span> {{ $anak->no_kk }}</div>
                    <div><span class="text-gray-500 block">Status:</span> {{ $anak->status_anak }}</div>
                    <div><span class="text-gray-500 block">Alamat:</span> {{ $anak->alamatDomisili->alamat_lengkap }}, Kel. {{ $anak->alamatDomisili->kelurahan->nama_kelurahan ?? '' }}</div>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold border-b pb-2 mb-4">Dokumen Persyaratan</h3>
                <ul class="divide-y divide-gray-200">
                    @forelse($anak->dokumen as $dok)
                        <li class="py-3 flex justify-between items-center">
                            <span>{{ $dok->kategoriDokumen->nama_dokumen }}</span>
                            <a href="{{ Storage::url($dok->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                        </li>
                    @empty
                        <li class="py-3 text-red-500 text-sm">Dokumen belum diunggah.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-gray-50 shadow sm:rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-bold mb-4">Keputusan Verifikasi</h3>
                <div class="flex space-x-4">
                    <form action="{{ route('verifikasi.approve', $anak->id) }}" method="POST" onsubmit="return confirm('Setujui data ini?');" class="flex-1">
                        @csrf
                        <input type="text" name="catatan" placeholder="Catatan persetujuan (opsional)" class="w-full mb-2 border-gray-300 rounded text-sm">
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-medium hover:bg-green-700">Setujui Data</button>
                    </form>
                    
                    <a href="{{ route('verifikasi.reject', $anak->id) }}" class="flex-1 text-center bg-red-600 text-white py-2 rounded font-medium hover:bg-red-700 mt-10">Tolak & Minta Perbaikan</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>