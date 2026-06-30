<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
                {{ __('Data Anak Yatim') }}
            </h2>
            @role('pendamping')
            <a href="{{ route('anak.create') }}"
                class="inline-flex items-center px-4 py-2 bg-[#004ac6] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-[#004ac6] focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah Data
            </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="p-6 border-b border-[#e5eeff]">
                    <div class="flex justify-between items-center mb-4">
                        <form method="GET" action="{{ route('anak.index') }}" class="w-full max-w-md">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full p-2 pl-10 text-sm text-gray-900 border border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6]"
                                    placeholder="Cari NIK atau Nama...">
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-[#434655]">
                            <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama & NIK</th>
                                    <th scope="col" class="px-6 py-3">Umur</th>
                                    <th scope="col" class="px-6 py-3">Orang Tua</th>
                                    <th scope="col" class="px-6 py-3">Status Data</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($anak as $index => $item)
                                    <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                        <td class="px-6 py-4">{{ $anak->firstItem() + $index }}</td>

                                        <td class="px-6 py-4">
                                            <div class="font-bold text-[#0b1c30]">{{ $item->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500">NIK: {{ $item->nik }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun
                                        </td>

                                        <td class="px-6 py-4 text-xs">
                                            <div>
                                                <span class="font-semibold text-gray-600">Ayah:</span>
                                                {{ $item->orangTua->where('jenis_orang_tua', 'Ayah')->first()->nama ?? '-' }}
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-600">Ibu:</span>
                                                {{ $item->orangTua->where('jenis_orang_tua', 'Ibu')->first()->nama ?? '-' }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            @php
                                                $badgeColor = match ($item->status_data) {
                                                    'Draft' => 'bg-gray-100 text-gray-800',
                                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                                    'Disetujui' => 'bg-green-100 text-green-800',
                                                    'Ditolak' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                                {{ $item->status_data }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('anak.show', $item->id) }}"
                                                class="font-medium text-[#004ac6] hover:underline">Detail</a>
                                            @role('pendamping')
                                            @if(in_array($item->status_data, ['Draft', 'Ditolak', 'Pending']))
                                                <a href="{{ route('anak.edit', $item->id) }}"
                                                    class="font-medium text-yellow-600 hover:underline">Edit</a>
                                            @endif
                                            @endrole
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                                <p>Tidak ada data anak ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $anak->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>