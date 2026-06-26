<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Kelola Akses: {{ strtoupper($role->name) }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('master.roles.permissions.sync', $role->id) }}" method="POST" class="bg-white p-6 shadow sm:rounded-lg">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($permissions as $permission)
                    <div class="flex items-center p-3 border rounded hover:bg-gray-50">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} 
                               class="h-4 w-4 text-indigo-600 rounded">
                        <label class="ml-2 text-sm text-gray-700">{{ $permission->name }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('master.roles.index') }}" class="mr-4 text-gray-600 py-2">Batal</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan Hak Akses</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>