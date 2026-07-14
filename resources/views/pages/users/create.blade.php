<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah User Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('users.store') }}" method="POST" class="p-6" 
                      x-data="{ loading: false }" 
                      @submit="loading = true">
                    @csrf
                    
                    @include('pages.users.form')

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm">Batal</a>
                        <button type="submit" 
                                :disabled="loading"
                                class="bg-indigo-600 text-white px-4 py-2 rounded flex items-center transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                                :class="loading ? 'opacity-75' : ''">
                            
                            <span x-show="!loading">Simpan</span>

                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>