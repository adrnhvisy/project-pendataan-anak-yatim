<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Log Aktivitas Sistem</h2>
    </x-slot>

    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Aksi</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</td>
                        <td class="px-6 py-4 text-indigo-600 font-semibold">{{ $log->action }}</td>
                        <td class="px-6 py-4">{{ $log->description }}</td>
                        <td class="px-6 py-4 text-xs text-gray-400 font-mono">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada log aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>