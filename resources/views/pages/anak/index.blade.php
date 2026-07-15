<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
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
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mx-4 sm:mx-0"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mx-4 sm:mx-0" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff] mx-4 sm:mx-0">
                <div class="p-4 sm:p-6 border-b border-[#e5eeff]">

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        
                        <!-- Form Pencarian dan Filter -->
                        <form method="GET" action="{{ route('anak.index') }}" class="w-full max-w-2xl flex flex-col sm:flex-row gap-2">
                            <!-- Input Pencarian Teks -->
                            <div class="relative flex-1">
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

                            <!-- Dropdown Filter Kelurahan -->
                            <select name="kelurahan" onchange="this.form.submit()" 
                                class="block w-full sm:w-auto p-2 text-sm text-gray-900 border border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6]">
                                <option value="">Semua Kelurahan</option>
                                
                                <!-- Looping data kelurahan dari database -->
                                @foreach($kelurahans as $kel)
                                    <option value="{{ $kel->id }}" {{ request('kelurahan') == $kel->id ? 'selected' : '' }}>
                                        {{ $kel->nama_kelurahan }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <div class="w-full sm:w-auto text-left sm:text-right">
                            @if (request('search') || request('kelurahan'))
                                <a href="{{ route('anak.index') }}" class="text-sm text-[#004ac6] hover:underline">
                                    Reset pencarian
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto pb-2">
                        <table class="w-full text-sm text-left text-[#434655]">
                            <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">No</th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Nama & NIK</th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Umur</th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Orang Tua</th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($anak as $index => $item)
                                    <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $anak->firstItem() + $index }}</td>

                                        <td class="px-6 py-4 min-w-[200px]">
                                            <div class="font-bold text-[#0b1c30]">{{ $item->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500">NIK: {{ $item->nik }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $umur = \Carbon\Carbon::parse($item->tanggal_lahir)->age;
                                            @endphp

                                            @if($umur > 18)
                                                <span class="text-red-600 font-bold">
                                                    {{ $umur }} Tahun (Melebihi Batas Umur)
                                                </span>
                                            @else
                                                <span class="text-gray-900">
                                                    {{ $umur }} Tahun
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-xs min-w-[150px]">
                                            <div class="mb-1">
                                                <span class="font-semibold text-gray-600">Ayah:</span>
                                                {{ $item->orangTua->where('jenis_orang_tua', 'Ayah')->first()->nama ?? '-' }}
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-600">Ibu:</span>
                                                {{ $item->orangTua->where('jenis_orang_tua', 'Ibu')->first()->nama ?? '-' }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right space-x-3 whitespace-nowrap">
                                            <a href="{{ route('anak.show', $item->id) }}"
                                                class="font-medium text-[#004ac6] hover:underline">Detail</a>
                                            @role('pendamping')
                                            @if(in_array($item->status_data, ['Draft', 'Ditolak']))
                                                <a href="{{ route('anak.edit', $item->id) }}"
                                                    class="font-medium text-yellow-600 hover:underline">Edit</a>
                                            @endif
                                            <form action="{{ route('anak.destroy', $item->id) }}" method="POST"
                                                class="inline-block form-hapus"
                                                data-confirm-message="Apakah Anda yakin ingin menghapus data atas nama {{ $item->nama_lengkap }}? SELURUH data terkait seperti alamat, orang tua, dokumen, dan riwayat akan ikut terhapus permanen.">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="text-red-600 hover:underline">
                                                    Hapus Data
                                                </button>
                                            </form>
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
                                @endempty
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