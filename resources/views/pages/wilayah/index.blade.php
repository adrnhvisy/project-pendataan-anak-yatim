<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">Master Wilayah (Kelurahan)</h2>
            <a href="{{ route('wilayah.create') }}"
                class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                + Tambah Kelurahan
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl border border-[#e5eeff] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-[#434655]">
                        <thead class="text-xs uppercase bg-[#f1f5f9]">
                            <tr>
                                <th class="px-6 py-4">Nama Kelurahan</th>
                                <th class="px-6 py-4">Kecamatan</th>
                                <th class="px-6 py-4">Kabupaten</th>
                                <th class="px-6 py-4">Kode Pos</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e5eeff]">
                            @forelse ($kelurahans as $item)
                                <tr class="hover:bg-blue-50/50 even:bg-[#F1F5F9]">
                                    <td class="px-6 py-4 font-bold">{{ $item->nama_kelurahan }}</td>
                                    <td class="px-6 py-4">{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->kecamatan->kabupaten->nama_kabupaten ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->kode_pos ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('wilayah.edit', $item->id) }}"
                                            class="text-[#004ac6] hover:underline mr-3">Edit</a>

                                        <form action="{{ route('wilayah.destroy', $item->id) }}" method="POST"
                                            class="inline form-hapus">
                                            @csrf @method('DELETE')

                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Data belum tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-[#e5eeff]">
                    {{ $kelurahans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>