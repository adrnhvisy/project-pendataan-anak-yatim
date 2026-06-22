<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Tambah Role Baru</h2>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="p-6 bg-white shadow-sm rounded-xl border border-gray-100">
            <!-- Form mengarah ke route store menggunakan method POST -->
            <form action="{{ route('superadmin.roles.store') }}" method="POST">
                @csrf
                
                <div class="grid gap-6">
                    <div>
                        <x-input-label for="name" value="Nama Role (Contoh: auditor, admin_desa)" />
                        <!-- Input otomatis fokus saat halaman dimuat menggunakan atribut 'autofocus' -->
                        <x-text-input id="name" name="name" type="text" class="block w-full mt-1" required autofocus autocomplete="off" />
                        
                        <!-- Menampilkan pesan error validasi jika nama role sudah ada -->
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end pt-4 space-x-3">
                        <a href="{{ route('superadmin.roles.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </a>
                        <x-primary-button>Simpan Role</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>