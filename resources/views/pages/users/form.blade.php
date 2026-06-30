<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
            class="mt-1 block w-full border-gray-300 rounded-md">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
            class="mt-1 block w-full border-gray-300 rounded-md">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}
        </label>
        <div class="relative">
            <input type="password" id="password" name="password" {{ isset($user) ? '' : 'required' }}
                class="mt-1 block w-full border-gray-300 rounded-md pr-10">

            <!-- Tombol mata -->
            <button type="button" id="togglePassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                <!-- Icon mata terbuka -->
                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <!-- Icon mata tertutup -->
                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.642-4.362m3.5-2.02A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.642 5.362M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <line x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="2" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }}
            class="mt-1 block w-full border-gray-300 rounded-md">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Role</label>
        <select name="roles" required
            class="mt-1 block w-full border-gray-300 rounded-md @error('roles') border-red-500 @enderror">
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ (isset($user) && $user->hasRole($role->name)) || old('roles') == $role->name ? 'selected' : '' }}>
                    {{ strtoupper($role->name) }}
                </option>
            @endforeach
        </select>
        @error('roles')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center mt-4">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active_checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded cursor-pointer">
        <label for="is_active_checkbox" id="is_active_label"
            class="ml-2 block text-sm text-gray-900 cursor-pointer select-none">
            {{ old('is_active', $user->is_active ?? true) ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
        </label>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                if (isPassword) {
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            });

            const checkbox = document.getElementById('is_active_checkbox');
            const label = document.getElementById('is_active_label');
            checkbox.addEventListener('change', function () {
                label.textContent = this.checked ? 'Nonaktifkan Akun' : 'Aktifkan Akun';
            });
        });
    </script>
</div>