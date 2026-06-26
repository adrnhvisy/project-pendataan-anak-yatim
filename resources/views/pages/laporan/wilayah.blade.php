<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Rekapitulasi Wilayah') }}
            </h2>
            <button type="button" onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Print
            </button>
        </div>
    </x-slot>

    <div class="py-12 print:py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg print:shadow-none p-8">
                
                <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
                    <h1 class="text-2xl font-bold uppercase text-gray-900">Rekapitulasi Data Anak Yatim per Wilayah</h1>
                    <p class="text-gray-600">Pemerintah Kabupaten Pelalawan</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-800 border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th rowspan="2" class="border border-gray-300 px-4 py-2 text-center w-10">No</th>
                                <th rowspan="2" class="border border-gray-300 px-4 py-2 text-center">Kelurahan</th>
                                <th rowspan="2" class="border border-gray-300 px-4 py-2 text-center">Total Data</th>
                                <th colspan="3" class="border border-gray-300 px-4 py-2 text-center bg-blue-50">Berdasarkan Status</th>
                                <th colspan="2" class="border border-gray-300 px-4 py-2 text-center bg-green-50">Status Verifikasi</th>
                            </tr>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-center bg-blue-50 text-xs">Yatim</th>
                                <th class="border border-gray-300 px-4 py-2 text-center bg-blue-50 text-xs">Piatu</th>
                                <th class="border border-gray-300 px-4 py-2 text-center bg-blue-50 text-xs">Yatim Piatu</th>
                                <th class="border border-gray-300 px-4 py-2 text-center bg-green-50 text-xs">Disetujui</th>
                                <th class="border border-gray-300 px-4 py-2 text-center bg-green-50 text-xs">Pending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data_wilayah) && count($data_wilayah) > 0)
                                @foreach($data_wilayah as $item)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                        <td class="border border-gray-300 px-4 py-2 font-medium">{{ $item->nama_kelurahan }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center font-bold">{{ $item->total }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->yatim }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->piatu }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->yatim_piatu }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center text-green-700 font-bold">{{ $item->disetujui }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center text-yellow-600">{{ $item->pending }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="border border-gray-300 px-4 py-8 text-center text-gray-500">Data rekapitulasi belum tersedia. Harap proses di controller.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>