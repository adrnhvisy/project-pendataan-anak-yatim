<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
                {{ __('Statistik Agregasi Wilayah') }}
            </h2>
            <a href="{{ route('laporan.index') }}"
                class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                    <h3 class="text-lg font-bold text-[#0b1c30]">Rekapitulasi Persebaran Anak Yatim</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-[#434655]">
                        <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                            <tr>
                                <th scope="col" class="px-6 py-3">Kecamatan</th>
                                <th scope="col" class="px-6 py-3">Kelurahan</th>
                                <th scope="col" class="px-6 py-3 text-center">Total Data Terdaftar</th>
                                <th scope="col" class="px-6 py-3 text-center">Total Data Valid (Disetujui)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                    <td class="px-6 py-4 font-medium text-[#0b1c30]">
                                        {{ $item->kelurahan_data->kecamatan->nama_kecamatan ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->kelurahan_data->nama_kelurahan ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-lg font-bold">{{ $item->total }}</td>
                                    <td class="px-6 py-4 text-center text-lg font-bold text-green-600">
                                        {{ $item->total_disetujui }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Data wilayah belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 p-4">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>