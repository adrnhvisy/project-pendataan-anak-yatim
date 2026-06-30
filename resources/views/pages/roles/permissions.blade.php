<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-[#0b1c30]">Izin Akses: {{ $role->name }}</h2></x-slot>
    <div class="py-12 bg-[#f8f9ff]">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('roles.permissions.update', $role->id) }}" method="POST" class="bg-white p-6 rounded-xl border border-[#e5eeff]">
                @csrf @method('PUT')
                @foreach($permissions as $module => $group)
                    <div class="mb-6">
                        <h4 class="font-bold text-[#004ac6] uppercase text-sm mb-3">{{ $module }}</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($group as $perm)
                                <label class="flex items-center space-x-2 text-sm text-[#434655]">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                        {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}
                                        class="rounded border-[#E2E8F0] text-[#004ac6] focus:ring-[#004ac6]">
                                    <span>{{ $perm->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="pt-4 border-t border-[#e5eeff] mt-6 text-right">
                    <button type="submit" class="px-6 py-2 bg-[#004ac6] text-white rounded-lg text-sm font-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>