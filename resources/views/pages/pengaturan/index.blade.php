<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <form action="{{ route('pengaturan.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">{{ session('success') }}</div>
                    @endif

                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Variabel Sistem</h3>
                        <p class="mt-1 text-sm text-gray-500">Sesuaikan nama instansi, kontak, dan parameter aplikasi lainnya.</p>
                    </div>

                    <div class="space-y-4">
                        @forelse($settings ?? [] as $setting)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</label>
                                <input type="text" name="settings[{{ $setting->key }}]" value="{{ old('settings.'.$setting->key, $setting->value) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @if($setting->keterangan)
                                    <p class="mt-1 text-xs text-gray-500">{{ $setting->keterangan }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 bg-gray-50 text-center text-gray-500 rounded">Belum ada pengaturan dinamis di database.</div>
                        @endforelse
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-medium text-sm">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>