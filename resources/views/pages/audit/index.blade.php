<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Audit Log Sistem') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 w-48">Waktu (WIB)</th>
                                <th class="px-6 py-3">Pengguna</th>
                                <th class="px-6 py-3">Modul / ID</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                                <th class="px-6 py-3">Deskripsi Aktivitas</th>
                                <th class="px-6 py-3">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($logs as $log)
                                <tr class="bg-white hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 text-xs">
                                        <div class="font-medium">{{ $log->created_at->translatedFormat('d M Y') }}</div>
                                        <div class="text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $log->user->name ?? 'Sistem / Guest' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-700">{{ $log->module }}</div>
                                        @if($log->record_id)
                                            <div class="text-xs text-gray-400">ID: {{ $log->record_id }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $actionColor = match($log->action) {
                                                'CREATE' => 'bg-green-100 text-green-800',
                                                'UPDATE' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'DELETE' => 'bg-red-100 text-red-800 border-red-200',
                                                'UPLOAD' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'LOGIN'  => 'bg-purple-100 text-purple-800 border-purple-200',
                                                default  => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-bold rounded {{ $actionColor }} border border-transparent">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 text-xs font-mono text-gray-500">
                                        {{ $log->ip_address ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada catatan log aktivitas dalam sistem.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($logs->hasPages())
                    <div class="p-4 border-t border-gray-200">
                        {{ $logs->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>