<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800">
            Data Anak Yatim
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">

        <div class="flex flex-col items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50 md:flex-row">
            <div class="mb-4 md:mb-0">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Anak Terdaftar</h3>
                <p class="text-sm text-gray-500">Menampilkan data sesuai hak akses wilayah Anda.</p>
            </div>

            @hasanyrole('pendamping|superadmin')
            <a href="{{ route('anak.create') }}"
                class="px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah Data Anak
            </a>
            @endhasanyrole
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4">No. Registrasi</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Kelurahan</th>
                        <th class="px-6 py-4">Status Anak</th>
                        <th class="px-6 py-4">Status Data</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($anak as $item)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-mono text-xs font-medium text-gray-900">
                                {{ $item->no_registrasi }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $item->nama_lengkap }}</div>
                                <div class="text-xs text-gray-400">NIK: {{ $item->nik }}</div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->kelurahan->nama_kelurahan ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->status_anak }}
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status_data == 'Draft')
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Draft</span>
                                @elseif($item->status_data == 'Pending')
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending
                                        (Proses Verifikasi)</span>
                                @elseif($item->status_data == 'Disetujui')
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('anak.show', $item->id) }}"
                                    class="font-medium text-indigo-600 hover:underline">Detail</a>

                                @if(request()->routeIs('anak.verifikasi') && auth()->user()->hasAnyRole(['kecamatan', 'kesra', 'superadmin']))
                                    <form action="{{ route('anak.verifikasi.action', $item->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="font-medium text-green-600 hover:underline"
                                            onclick="return confirm('Yakin ingin menyetujui data ini?')">
                                            Setujui
                                        </button>
                                    </form>
                                @endif

                                @hasanyrole(['superadmin', 'pendamping', 'kesra'])
                                @if($item->status_data == 'Draft' || $item->status_data == 'Ditolak')
                                    <a href="{{ route('anak.edit', $item->id) }}"
                                        class="font-medium text-blue-600 hover:underline">Edit</a>
                                @endif
                                @endhasanyrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data anak yatim di wilayah Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $anak->links() }}
        </div>
    </div>
</x-app-layout>