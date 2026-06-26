<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Data Anak Yatim') }}
            </h2>
            <div class="space-x-2">
                <button type="button" onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Print
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 print:py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Panel Filter (Sembunyi saat diprint) -->
            <div class="bg-white p-6 rounded-lg shadow print:hidden border border-gray-200">
                <form method="GET" action="{{ route('laporan.anak') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Anak</label>
                        <select name="status_anak" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Semua Status</option>
                            <option value="Yatim">Yatim</option>
                            <option value="Piatu">Piatu</option>
                            <option value="Yatim Piatu">Yatim Piatu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                        <select name="status_data" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Semua Data</option>
                            <option value="Disetujui" selected>Telah Disetujui</option>
                            <option value="Pending">Menunggu Verifikasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Tanggal Daftar</label>
                        <div class="flex space-x-2">
                            <input type="date" name="start_date" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <input type="date" name="end_date" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-medium">Buat Laporan</button>
                    </div>
                </form>
            </div>

            <!-- Area Kertas Laporan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg print:shadow-none print:border-none p-8">
                
                <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
                    <h1 class="text-2xl font-bold uppercase text-gray-900">Laporan Pendataan Anak Yatim</h1>
                    <p class="text-gray-600">Pemerintah Kabupaten Pelalawan</p>
                    <p class="text-sm text-gray-500 mt-2">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-800 border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-center w-10">No</th>
                                <th class="border border-gray-300 px-4 py-2">No Registrasi</th>
                                <th class="border border-gray-300 px-4 py-2">Nama Lengkap</th>
                                <th class="border border-gray-300 px-4 py-2">NIK</th>
                                <th class="border border-gray-300 px-4 py-2">Status Anak</th>
                                <th class="border border-gray-300 px-4 py-2">Kelurahan</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Status Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data_laporan) && count($data_laporan) > 0)
                                @foreach($data_laporan as $item)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $item->no_registrasi }}</td>
                                        <td class="border border-gray-300 px-4 py-2 font-bold">{{ $item->nama_lengkap }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $item->nik }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $item->status_anak }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $item->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->status_data }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="border border-gray-300 px-4 py-8 text-center text-gray-500 italic">Silakan filter data untuk menampilkan hasil laporan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>