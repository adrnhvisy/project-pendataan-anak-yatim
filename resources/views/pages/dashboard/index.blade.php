<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                <!-- Card Total Anak -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                    <p class="text-sm font-medium text-[#434655] uppercase tracking-wider">Total Anak</p>
                    <p class="text-4xl font-bold text-[#004ac6] mt-2">{{ $stats['total'] ?? 0 }}</p>
                </div>

                <!-- Card Menunggu Verifikasi -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                    <p class="text-sm font-medium text-[#434655] uppercase tracking-wider">Menunggu Verifikasi</p>
                    <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] ?? 0 }}</p>
                </div>

                <!-- Card Disetujui -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                    <p class="text-sm font-medium text-[#434655] uppercase tracking-wider">Disetujui</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['disetujui'] ?? 0 }}</p>
                </div>

                <!-- Tampil khusus Kesra atau Superadmin (Total Kecamatan) -->
                @if(auth()->user()->hasRole('kesra') || auth()->user()->hasRole('superadmin'))
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                        <p class="text-sm font-medium text-[#434655] uppercase tracking-wider">Total Kecamatan</p>
                        <p class="text-4xl font-bold text-teal-600 mt-2">{{ $stats['total_kecamatan'] ?? 0 }}</p>
                    </div>
                @endif

                <!-- Tampil untuk Kecamatan, Kesra, dan Superadmin (Total Kelurahan) -->
                @if(!auth()->user()->hasRole('pendamping'))
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff]">
                        <p class="text-sm font-medium text-[#434655] uppercase tracking-wider">Total Kelurahan</p>
                        <p class="text-4xl font-bold text-purple-600 mt-2">{{ $stats['total_kelurahan'] ?? 0 }}</p>
                    </div>
                @endif
            </div>
            @if(get_setting('buku_panduan'))
                <div
                    class="bg-white p-6 rounded-xl shadow-sm border border-[#e5eeff] flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-[#0b1c30]">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-[#737686] mt-1">
                            Silakan gunakan dashboard ini untuk memantau data anak yatim. Jika mengalami kendala, Anda dapat
                            melihat panduan penggunaan sistem.
                        </p>
                    </div>
                    <a href="{{ asset('storage/' . get_setting('buku_panduan')) }}" target="_blank"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-[#004ac6] hover:bg-blue-800 text-white font-bold text-sm rounded-lg transition-colors shrink-0">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Lihat Buku Panduan
                    </a>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="p-6 bg-white border-b border-[#e5eeff]">
                    <h3 class="text-lg font-bold text-[#0b1c30] mb-4">Data Anak Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-[#434655]">
                            <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No Registrasi</th>
                                    <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                                    <th scope="col" class="px-6 py-3">Kelurahan</th>
                                    <th scope="col" class="px-6 py-3">Status Anak</th>
                                    <th scope="col" class="px-6 py-3">Status Data</th>
                                    @role('kesra|kecamatan|pendamping')
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($anakTerbaru as $anak)
                                    <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                        <td class="px-6 py-4 font-medium text-[#0b1c30]">{{ $anak->no_registrasi }}</td>
                                        <td class="px-6 py-4">{{ $anak->nama_lengkap }}</td>
                                        <td class="px-6 py-4">{{ $anak->alamatDomisili->kelurahan->nama_kelurahan ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">{{ $anak->status_anak }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $badgeColor = match ($anak->status_data) {
                                                    'Draft' => 'bg-gray-100 text-gray-800',
                                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                                    'Disetujui' => 'bg-green-100 text-green-800',
                                                    'Ditolak' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                                {{ $anak->status_data }}
                                            </span>
                                        </td>
                                        @role('kesra|kecamatan|pendamping')
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('anak.show', $anak->id) }}"
                                                class="font-medium text-[#004ac6] hover:underline">Detail</a>
                                        </td>
                                        @endrole
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            Tidak ada data anak terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @role('superadmin')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="p-6 bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-[#0b1c30]">Log Aktivitas Terbaru</h3>
                        <a href="{{ route('audit.index') }}" class="text-sm text-[#004ac6] hover:underline">Lihat
                            Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-[#434655]">
                            <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Waktu</th>
                                    <th scope="col" class="px-6 py-3">User</th>
                                    <th scope="col" class="px-6 py-3">Modul</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($auditTerbaru as $log)
                                    <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4">{{ $log->user->name ?? 'System' }}</td>
                                        <td class="px-6 py-4">{{ $log->module }}</td>
                                        <td class="px-6 py-4 font-semibold">{{ $log->action }}</td>
                                        <td class="px-6 py-4">{{ $log->description }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada log aktivitas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endrole

        </div>
    </div>
</x-app-layout>