<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
                {{ __('Laporan Data Anak') }}
            </h2>
            <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                <form method="GET" action="{{ route('laporan.anak') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/3">
                        <x-input-label for="status_data" value="Filter Status Data" />
                        <select name="status_data" id="status_data" class="mt-1 block w-full border-[#E2E8F0] rounded-md shadow-sm focus:border-[#004ac6] focus:ring-[#004ac6]">
                            <option value="">Semua Status</option>
                            <option value="Pending" {{ request('status_data') == 'Pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                            <option value="Disetujui" {{ request('status_data') == 'Disetujui' ? 'selected' : '' }}>Disetujui (Valid)</option>
                            <option value="Ditolak" {{ request('status_data') == 'Ditolak' ? 'selected' : '' }}>Ditolak (Revisi)</option>
                        </select>
                    </div>
                    <div>
                        <x-primary-button>Terapkan Filter</x-primary-button>
                        @if(request()->anyFilled(['status_data']))
                            <a href="{{ route('laporan.anak') }}" class="ml-2 text-sm text-gray-500 hover:underline">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-[#434655]">
                        <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">No Registrasi</th>
                                <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                                <th scope="col" class="px-6 py-3">Kelurahan/Kecamatan</th>
                                <th scope="col" class="px-6 py-3">Status Anak</th>
                                <th scope="col" class="px-6 py-3">Status Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                    <td class="px-6 py-4">{{ $data->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 font-medium text-[#0b1c30]">{{ $item->no_registrasi }}</td>
                                    <td class="px-6 py-4">{{ $item->nama_lengkap }}</td>
                                    <td class="px-6 py-4">{{ $item->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }} <br> <span class="text-xs text-gray-500">{{ $item->alamatDomisili->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</span></td>
                                    <td class="px-6 py-4">{{ $item->status_anak }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $item->status_data == 'Disetujui' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $item->status_data }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data untuk laporan ini.</td>
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