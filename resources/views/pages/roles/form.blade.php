@csrf
<div>
    <label class="block text-sm font-bold text-[#0b1c30]">Nama Role</label>
    <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" class="w-full mt-1 border-[#E2E8F0] rounded-lg focus:ring-[#004ac6] focus:border-[#004ac6]" required>
    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>