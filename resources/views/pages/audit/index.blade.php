<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0b1c30] leading-tight">
            {{ __('Audit Logs (Log Sistem)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-[#e5eeff]">
                <div class="px-6 py-4 border-b border-[#e5eeff] bg-[#f8f9ff]">
                    <p class="text-sm text-[#434655]">Log rekam jejak aktivitas kritis di dalam sistem, khusus untuk pemantauan Superadmin.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-[#434655]">
                        <thead class="text-xs text-[#434655] uppercase bg-[#f1f5f9]">
                            <tr>
                                <th scope="col" class="px-6 py-3">Waktu</th>
                                <th scope="col" class="px-6 py-3">Pengguna</th>
                                <th scope="col" class="px-6 py-3">Modul</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                                <th scope="col" class="px-6 py-3">Deskripsi</th>
                                <th scope="col" class="px-6 py-3">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="bg-white border-b border-[#e5eeff] even:bg-[#F1F5F9]">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-6 py-4 font-medium text-[#0b1c30]">{{ $log->user->name ?? 'System' }} <br><span class="text-xs font-normal text-gray-500">{{ $log->user->email ?? '' }}</span></td>
                                    <td class="px-6 py-4"><span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded border border-blue-100">{{ $log->module }}</span></td>
                                    <td class="px-6 py-4 font-bold">{{ $log->action }}</td>
                                    <td class="px-6 py-4">{{ $log->description }}</td>
                                    <td class="px-6 py-4 text-xs font-mono text-gray-500">{{ $log->ip_address ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Log sistem kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 p-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>