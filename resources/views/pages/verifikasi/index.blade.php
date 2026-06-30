<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
            {{ __('Antrian Verifikasi Data Anak') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-[#EF4444] text-[#EF4444] px-4 py-3 rounded-lg relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="p-6 border-b border-[#e5eeff] bg-[#f8f9ff]">
                    <p class="text-sm text-[#434655]">Berikut adalah data anak yatim yang telah diajukan oleh Admin Kelurahan dan menunggu verifikasi dari Kelurahan.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-[#434655]">
                        <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Data Anak</th>
                                <th scope="col" class="px-6 py-3">Kelurahan/Kecamatan</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>
                                <th scope="col" class="px-6 py-3 text-center font-bold text-[#0b1c30]">Detail</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi Verifikasi</th>
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
                                        {{ $item->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }} <br>
                                        <span class="text-xs text-gray-500">{{ $item->alamatDomisili->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('anak.show', $item->id) }}?from=verifikasi"
                                            class="inline-flex items-center text-xs font-semibold px-3 py-1 bg-[#e5eeff] text-[#004ac6] rounded-full hover:bg-blue-200 transition-colors duration-200">
                                            Verifikasi / Detail
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        @if($item->status_data === 'Pending')
                                            <form action="{{ route('verifikasi.approve', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Setujui data ini secara resmi? Pastikan dokumen sudah dicek.')"
                                                    class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Approve</button>
                                            </form>

                                            <button type="button"
                                                onclick="confirmReject('{{ route('verifikasi.processReject', $item->id) }}', '{{ $item->id }}', {{ json_encode($item->catatan ?? '') }})"
                                                class="text-red-600 hover:text-red-800 font-semibold text-xs">
                                                Reject
                                            </button>

                                            <form id="form-reject-{{ $item->id }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="keterangan" id="input-keterangan-{{ $item->id }}">
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-500 italic">{{ $item->status_data }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <p>Antrian verifikasi kosong.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 p-4">
                    {{ $anak->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmReject(actionUrl, itemId, catatan) {
            Swal.fire({
                title: 'Tolak Data Anak',
                html: `
                    <div class="text-left mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Saat Ini:</label>
                        <div class="p-3 bg-gray-50 border rounded text-sm text-gray-600 italic">
                            ${catatan ? catatan : 'Tidak ada catatan.'}
                        </div>
                    </div>
                    <div class="text-left font-semibold mb-2">Alasan Penolakan Baru:</div>
                `,
                input: 'textarea',
                inputPlaceholder: 'Masukkan alasan penolakan minimal 10 karakter...',
                inputAttributes: { 'minlength': 10, 'required': true },
                showCancelButton: true,
                confirmButtonText: 'Tolak Data',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                preConfirm: (value) => {
                    if (!value || value.length < 10) {
                        Swal.showValidationMessage('Alasan harus diisi minimal 10 karakter');
                    }
                    return value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-reject-' + itemId);
                    const input = document.getElementById('input-keterangan-' + itemId);
                    if (form && input) {
                        form.action = actionUrl;
                        input.value = result.value;
                        form.submit();
                    }
                }
            });
        }
    </script>
</x-app-layout>