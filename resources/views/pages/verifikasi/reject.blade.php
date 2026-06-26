<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tolak Data: {{ $anak->nama_lengkap }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('verifikasi.reject', $anak->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alasan Penolakan / Catatan Perbaikan *</label>
                        <textarea name="catatan" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
                        @error('catatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('verifikasi.show', $anak->id) }}" class="px-4 py-2 bg-gray-200 rounded text-gray-700 text-sm font-medium">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded text-sm font-medium hover:bg-red-700">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>