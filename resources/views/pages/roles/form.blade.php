<div>
    <label class="block text-sm font-medium text-gray-700">Nama Role</label>
    <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" required placeholder="Contoh: pendamping, kecamatan" class="mt-1 block w-full border-gray-300 rounded-md">
    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>