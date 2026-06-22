<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800">
            Manajemen Pengguna
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Akun Sistem</h3>
            <a href="{{ route('superadmin.users.create') }}"
                class="px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah Akun Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Role / Hak Akses</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full uppercase">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                    <span class="flex items-center text-green-600">
                                        <span class="w-2 h-2 mr-2 bg-green-600 rounded-full"></span> Aktif
                                    </span>
                                @else
                                    <span class="flex items-center text-red-600">
                                        <span class="w-2 h-2 mr-2 bg-red-600 rounded-full"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>