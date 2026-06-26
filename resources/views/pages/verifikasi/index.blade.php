<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Antrean Verifikasi Data</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Tgl Daftar</th>
                            <th class="px-6 py-3">Nama Anak / NIK</th>
                            <th class="px-6 py-3">Kelurahan</th>
                            <th class="px-6 py-3 text-center">Berkas</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingAnak as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $item->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $item->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->nik }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $item->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $item->dokumen()->count() }} Dokumen</td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="{{ route('verifikasi.show', $item->id) }}" class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded font-medium hover:bg-indigo-200">Periksa Data</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada antrean verifikasi saat ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t">{{ $pendingAnak->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>