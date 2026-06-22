<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Master Data: Kategori Dokumen</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
        <table class="w-full text-left text-gray-600">
            <thead class="bg-gray-50 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Dokumen</th>
                    <th class="px-4 py-3">Status Wajib</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kategori as $item)
                <tr>
                    <td class="px-4 py-3">{{ $item->nama_dokumen }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded {{ $item->is_wajib ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $item->is_wajib ? 'Wajib' : 'Opsional' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>