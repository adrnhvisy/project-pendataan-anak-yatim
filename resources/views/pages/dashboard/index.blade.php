<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium">Selamat datang, <span class="font-bold text-indigo-600">{{ Auth::user()->name }}</span>! 👋</h3>
                        <p class="text-sm text-gray-500 mt-1">Anda login sebagai {{ Auth::user()->roles->pluck('name')->implode(', ') ?: 'Pengguna' }}. Berikut adalah ringkasan data saat ini.</p>
                    </div>
                    <div class="hidden md:block text-right">
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistik Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Data</div>
                        <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['total'] }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-gray-400 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Draft</div>
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['draft'] }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending</div>
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['pending'] }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Disetujui</div>
                        <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['disetujui'] }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Ditolak</div>
                        <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $statistics['ditolak'] }}</div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>