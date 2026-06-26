<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Anak Yatim') }}
            </h2>
            @role('pendamping')
            <a href="{{ route('anak.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Tambah Data
            </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 font-semibold">Total Data</p>
                    <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 font-semibold">Pending</p>
                    <p class="text-2xl font-bold">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 font-semibold">Disetujui</p>
                    <p class="text-2xl font-bold">{{ $stats['disetujui'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 font-semibold">Ditolak</p>
                    <p class="text-2xl font-bold">{{ $stats['ditolak'] }}</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white p-4 rounded-lg shadow">
                <form method="GET" action="{{ route('anak.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIK / No Registrasi..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <select name="status_data" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status Data</option>
                        <option value="Draft" {{ request('status_data') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Pending" {{ request('status_data') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ request('status_data') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status_data') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <select name="status_anak" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status Anak</option>
                        <option value="Yatim" {{ request('status_anak') == 'Yatim' ? 'selected' : '' }}>Yatim</option>
                        <option value="Piatu" {{ request('status_anak') == 'Piatu' ? 'selected' : '' }}>Piatu</option>
                        <option value="Yatim Piatu" {{ request('status_anak') == 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                    </select>
                    @if(!auth()->user()->hasRole('pendamping'))
                    <select name="kelurahan_id" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kelurahan</option>
                        @foreach($kelurahanList as $kel)
                            <option value="{{ $kel->id }}" {{ request('kelurahan_id') == $kel->id ? 'selected' : '' }}>{{ $kel->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                    @endif
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filter</button>
                    <a href="{{ route('anak.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-center flex items-center justify-center">Reset</a>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 w-10 text-center">No</th>
                                <th class="px-6 py-3">NIK</th>
                                <th class="px-6 py-3">Nama Anak</th>
                                <th class="px-6 py-3">Nama Ayah - Ibu</th>
                                <th class="px-6 py-3 text-center">Umur</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anak as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-center font-medium text-gray-900">
                                        {{ $anak->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $item->nik }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ $item->nama_lengkap }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $ayah = $item->orangTua->where('jenis_orang_tua', 'Ayah')->first();
                                            $ibu = $item->orangTua->where('jenis_orang_tua', 'Ibu')->first();
                                        @endphp
                                        <div class="text-gray-900">Ayah: <span class="font-semibold">{{ $ayah->nama ?? '-' }}</span></div>
                                        <div class="text-gray-900">Ibu: <span class="font-semibold">{{ $ibu->nama ?? '-' }}</span></div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-gray-100 rounded-full font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-3">
                                        <a href="{{ route('anak.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Detail</a>
                                        @role('pendamping')
                                            <a href="{{ route('anak.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 font-medium">Edit</a>
                                        @endrole
                                        <a href="{{ route('anak.dokumen.index', $item->id) }}" class="text-purple-600 hover:text-purple-900 font-medium">Dokumen</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data anak yatim yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t">
                    {{ $anak->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>