<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="p-6 bg-white shadow-sm rounded-xl border border-gray-100">
            <form action="{{ isset($user) ? route('superadmin.users.update', $user->id) : route('superadmin.users.store') }}" method="POST">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="grid gap-6">
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" name="name" type="text" value="{{ $user->name ?? '' }}" class="block w-full mt-1" required />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" value="{{ $user->email ?? '' }}" class="block w-full mt-1" required />
                    </div>

                    @if(!isset($user))
                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" name="password" type="password" class="block w-full mt-1" required />
                    </div>
                    @endif

                    <div>
                        <x-input-label for="role" value="Pilih Role" />
                        <select name="role" id="role" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @foreach(['superadmin', 'kesra', 'kecamatan', 'pendamping'] as $roleName)
                                <option value="{{ $roleName }}" {{ (isset($user) && $user->hasRole($roleName)) ? 'selected' : '' }}>
                                    {{ ucfirst($roleName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @isset($user)
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" {{ $user->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-600">Akun Aktif</label>
                    </div>
                    @endisset
                    
                    <div class="flex justify-end pt-4">
                        <x-primary-button>{{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>