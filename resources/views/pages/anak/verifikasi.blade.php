<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Verifikasi Data Anak</h2>
    </x-slot>

    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Kelurahan</th>
                    <th class="px-6 py-4">Tanggal Daftar</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($anak as $item)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama_lengkap }}</td>
                        <td class="px-6 py-4">{{ $item->kelurahan->nama_kelurahan }}</td>
                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('anak.approve', $item->id) }}" method="POST">
                                @csrf
                                <a href="{{ route('anak.show', $item->id) }}"
                                    class="text-indigo-600 hover:underline mr-3">Detail</a>
                                @role('superadmin | kesra')
                                    <button type="submit"
                                        class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                                        Setujui
                                    </button>
                                @endrole
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">Tidak ada data pending.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>