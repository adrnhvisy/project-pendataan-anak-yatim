<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Manajemen Role') }}</h2>
            <a href="{{ route('roles.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium">+ Tambah Role</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-50 border-b uppercase">
                        <tr>
                            <th class="px-6 py-3">Nama Role</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-bold uppercase text-gray-900">{{ $role->name }}</td>
                            <td class="px-6 py-4 text-center space-x-3">
                                <a href="{{ route('roles.edit', $role->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <a href="{{-- route('roles.permissions',$role->id) --}}" class="text-blue-600 hover:underline">Kelola Akses</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus role ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>