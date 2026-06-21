<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800">
            Dashboard Statistik
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
        
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Total Anak Yatim</h3>
                <span class="flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-100 rounded-full">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-gray-800">{{ $stats['total_anak'] }}</p>
            <p class="mt-1 text-xs text-gray-400">Data terdaftar di wilayah Anda</p>
        </div>

        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Disetujui</h3>
                <span class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-green-600">{{ $stats['anak_disetujui'] }}</p>
            <p class="mt-1 text-xs text-gray-400">Telah diverifikasi Kesra</p>
        </div>

        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Menunggu Verifikasi</h3>
                <span class="flex items-center justify-center w-8 h-8 text-yellow-600 bg-yellow-100 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-yellow-500">{{ $stats['anak_pending'] }}</p>
            <p class="mt-1 text-xs text-gray-400">Perlu tindakan</p>
        </div>

        @role('superadmin')
        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-500">Total Pengguna</h3>
                <span class="flex items-center justify-center w-8 h-8 text-purple-600 bg-purple-100 rounded-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-purple-600">{{ $stats['total_user'] }}</p>
            <p class="mt-1 text-xs text-gray-400">Akun sistem aktif</p>
        </div>
        @endrole

    </div>
</x-app-layout>