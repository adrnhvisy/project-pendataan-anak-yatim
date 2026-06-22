<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Konfigurasi Sistem</h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-2xl mx-auto mt-4">
            <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-2xl mx-auto">
        <div class="p-6 bg-white shadow-sm rounded-xl border border-gray-100">
            <form action="{{ route('superadmin.pengaturan.update') }}" method="POST">
                @csrf
                @foreach($pengaturan as $item)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 capitalize">
                            {{ str_replace('_', ' ', $item->key) }}
                        </label>
                        <input type="text" name="{{ $item->key }}" value="{{ $item->value }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">{{ $item->keterangan }}</p>
                    </div>
                @endforeach

                <div class="flex justify-end mt-6">
                    <x-primary-button>Update Pengaturan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>