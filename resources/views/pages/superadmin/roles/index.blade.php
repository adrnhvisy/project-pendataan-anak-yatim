<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800">
            Manajemen Role & Hak Akses
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl">
        <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Role Sistem</h3>
            <a href="{{ route('superadmin.roles.create') }}"
                class="px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah Role Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-12">No</th>
                        <th scope="col" class="px-6 py-4">Nama Role</th>
                        <th scope="col" class="px-6 py-4">Guard</th>
                        <th scope="col" class="px-6 py-4">Jumlah Pengguna</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($roles as $index => $role)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full uppercase">
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $role->guard_name }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="font-medium text-gray-900">{{ \App\Models\User::role($role->name)->count() }}</span>
                                Akun
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit Hak Akses</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data role.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>