<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-[#0b1c30]">Daftar Role</h2>
            {{-- <ahref="route('roles.create')" }} class="px-4 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">+ Tambah Role</a>--}}
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9ff]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-[#e5eeff] overflow-hidden">
                <table class="w-full text-sm text-left text-[#434655]">
                    <thead class="text-xs uppercase bg-[#f1f5f9]">
                        <tr>
                            <th class="px-6 py-4">Nama Role</th>
                            <th class="px-6 py-4">Total User</th>
                            {{--<th class="px-6 py-4">Total Permission</th>
                            <th class="px-6 py-4 text-right">Aksi</th>--}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e5eeff]">
                        @foreach ($roles as $role)
                            <tr class="hover:bg-blue-50/50 even:bg-[#F1F5F9]">
                                <td class="px-6 py-4 font-bold text-[#0b1c30]">{{ $role->name }}</td>
                                <td class="px-6 py-4">{{ $role->users_count }}</td>
                                {{-- <tdclass="px-6py-4">$role->permissions_count</td> --}}
                                {{-- <td class="px-6 py-4 text-right">
                                    <a href="{{ route('roles.permissions', $role->id) }}" class="text-[#004ac6] hover:underline mr-3">Izin</a>
                                    <a href="{{ route('roles.edit', $role->id) }}" class="text-yellow-600 hover:underline mr-3">Edit</a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin?')" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>