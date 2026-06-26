<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}</label>
        <input type="password" name="password" {{ isset($user) ? '' : 'required' }} class="mt-1 block w-full border-gray-300 rounded-md">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Role</label>
        <select name="roles[]" required class="mt-1 block w-full border-gray-300 rounded-md">
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}>{{ strtoupper($role->name) }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex items-center mt-4">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
        <label class="ml-2 block text-sm text-gray-900">Akun Aktif</label>
    </div>
</div>