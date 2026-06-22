<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Laporan Statistik Data Anak</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Total Anak</p>
                <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ $stats['total'] }}</p>
            </div>
            
            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl border-l-4 border-l-yellow-400">
                <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Menunggu Verif</p>
                <p class="text-4xl font-extrabold text-yellow-600 mt-2">{{ $stats['pending'] }}</p>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl border-l-4 border-l-green-500">
                <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Disetujui</p>
                <p class="text-4xl font-extrabold text-green-600 mt-2">{{ $stats['disetujui'] }}</p>
            </div>

            <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl border-l-4 border-l-gray-400">
                <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Draft</p>
                <p class="text-4xl font-extrabold text-gray-600 mt-2">{{ $stats['draft'] }}</p>
            </div>
        </div>

        <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Export Laporan</h3>
            <p class="text-sm text-gray-500 mb-6">Unduh data anak yatim untuk keperluan arsip atau laporan fisik ke dinas terkait.</p>
            
            <div class="flex gap-4">
                <a href="{{ route('anak.export.excel') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V4a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2zM9 9H7v2h2v2H7v2h2v2h2v-2h2v-2h-2V9h2V7h-2V5h-2v2H9v2z"/></svg>
                    Download Excel
                </a>
                
                <a href="{{ route('anak.export.pdf') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                   <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v2H7V5zm0 4h6v2H7V9zm0 4h6v2H7v-2z"/></svg>
                   Download PDF
                </a>
            </div>
        </div>
    </div>
</x-app-layout>