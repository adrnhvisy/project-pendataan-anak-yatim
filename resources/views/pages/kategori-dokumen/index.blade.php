<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-[#0b1c30]">Kategori Dokumen</h2>
            <a href="{{ route('kategori-dokumen.create') }}"
                class="bg-[#004ac6] text-white px-4 py-2 rounded-lg text-sm font-bold">+ Tambah Kategori</a>
        </div>
    </x-slot>
    @if(session('error'))
        <div
            class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div
            class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12 bg-[#f8f9ff]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-[#e5eeff] overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#f1f5f9] text-[#0b1c30] uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Dokumen</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Penggunaan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e5eeff]">
                        @forelse($kategori as $item)
                            <tr class="even:bg-[#f1f5f9]">
                                <td class="px-6 py-4 flex justify-center items-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-bold">{{ $item->nama_dokumen }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-bold {{ $item->is_wajib ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $item->is_wajib ? 'Wajib' : 'Opsional' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $item->dokumen_anak_count }} dokumen</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('kategori-dokumen.edit', $item->id) }}"
                                        class="text-[#004ac6] hover:underline font-medium mr-3">Edit</a>

                                    <form action="{{ route('kategori-dokumen.destroy', $item->id) }}" method="POST"
                                        class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 hover:underline font-medium delete-btn">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center">Data kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menggunakan event delegation untuk menangani form
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Hentikan submit langsung

                    const form = this;
                    const button = form.querySelector('.delete-btn');

                    Swal.fire({
                        title: 'Hapus Kategori Dokumen?',
                        text: 'Kategori dokumen yang sudah dihapus tidak dapat dikembalikan. Pastikan data ini memang sudah tidak digunakan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626', // Red-600
                        cancelButtonColor: '#64748b',  // Slate-500
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Ubah tombol menjadi mode loading
                            button.disabled = true;
                            button.innerHTML = `
                                <span class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    Menghapus...
                                </span>
                            `;

                            // Submit form secara manual
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>