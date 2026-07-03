<div class="grid grid-cols-1 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
            class="mt-1 block w-full border-gray-300 rounded-md">
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
            class="mt-1 block w-full border-gray-300 rounded-md">
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Password {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '*' }}
        </label>
        <div class="relative">
            <input type="password" id="password" name="password" {{ isset($user) ? '' : 'required' }} 
                class="mt-1 block w-full border-gray-300 rounded-md pr-10">
            <button type="button" id="togglePassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.642-4.362m3.5-2.02A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.642 5.362M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <line x1="3" y1="3" x2="21" y2="21" stroke="currentColor" stroke-width="2" />
                </svg>
            </button>
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">
                {{ $message == 'Kolom kata sandi wajib diisi.' ? 'Password wajib diisi' : $message }}
            </p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" {{ isset($user) ? '' : 'required' }}
            class="mt-1 block w-full border-gray-300 rounded-md">
        @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Role</label>
        <select name="roles" id="roleSelect" required class="mt-1 block w-full border-gray-300 rounded-md">
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

    <div id="locationFields" class="grid grid-cols-1 gap-6 hidden">
        <div id="field_kabupaten">
            <label class="block text-sm font-medium text-gray-700">Kabupaten</label>
            <select name="kabupaten_id" id="kabSelect" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Pilih Kabupaten --</option>
                @foreach($kabupaten as $item)
                    <option value="{{ $item->id }}" {{ old('kabupaten_id', $user->kabupaten_id ?? '') == $item->id ? 'selected' : '' }}>{{ $item->nama_kabupaten }}</option>
                @endforeach
            </select>
        </div>

        <div id="field_kecamatan" class="hidden">
            <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
            <select name="kecamatan_id" id="kecSelect" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Pilih Kecamatan --</option>
                @foreach($kecamatan as $item)
                    <option value="{{ $item->id }}" data-parent="{{ $item->kabupaten_id }}" {{ old('kecamatan_id', $user->kecamatan_id ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_kecamatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="field_kelurahan" class="hidden">
            <label class="block text-sm font-medium text-gray-700">Kelurahan</label>
            <select name="kelurahan_id" id="kelSelect" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Pilih Kelurahan --</option>
                @foreach($kelurahan as $item)
                    <option value="{{ $item->id }}" data-parent="{{ $item->kecamatan_id }}" {{ old('kelurahan_id', $user->kelurahan_id ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_kelurahan }}
                    </option>
                @endforeach
            </select>
        </div>
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
            // Password Toggle
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            togglePassword.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                document.getElementById('eyeOpen').classList.toggle('hidden');
                document.getElementById('eyeClosed').classList.toggle('hidden');
            });

            // Cascading Logic
            const roleSelect = document.getElementById('roleSelect');
            const kabSelect = document.getElementById('kabSelect');
            const kecSelect = document.getElementById('kecSelect');
            const kelSelect = document.getElementById('kelSelect');

            function filterDropdown(source, target, parentAttr) {
                const parentId = source.value;
                const options = target.querySelectorAll('option');

                // 1. Jika parent kosong, nonaktifkan dan sembunyikan opsi
                if (!parentId) {
                    target.value = "";
                    target.disabled = true; // Kunci dropdown anak
                    options.forEach(opt => {
                        if (opt.value !== "") {
                            opt.hidden = true;
                            opt.disabled = true;
                        }
                    });
                    return;
                }

                // 2. Jika parent ada nilainya, buka kunci dropdown
                target.disabled = false;

                options.forEach(opt => {
                    if (opt.value === "") return; // Lewati placeholder

                    // Gunakan HTML attributes 'hidden' & 'disabled' agar stabil di semua browser
                    if (opt.getAttribute(parentAttr) === parentId) {
                        opt.hidden = false;
                        opt.disabled = false;
                        opt.style.display = ''; // Fallback
                    } else {
                        opt.hidden = true;
                        opt.disabled = true;
                        opt.style.display = 'none'; // Fallback
                        if (opt.selected) target.value = "";
                    }
                });
            }

            function updateVisibility() {
                const role = roleSelect.value;
                document.getElementById('locationFields').classList.toggle('hidden', role === '');
                document.getElementById('field_kabupaten').classList.toggle('hidden', role === '');
                document.getElementById('field_kecamatan').classList.toggle('hidden', !['kecamatan', 'pendamping'].includes(role));
                document.getElementById('field_kelurahan').classList.toggle('hidden', role !== 'pendamping');
            }

            // Event Listeners
            roleSelect.addEventListener('change', updateVisibility);

            kabSelect.addEventListener('change', () => {
                filterDropdown(kabSelect, kecSelect, 'data-parent');
                // Jika kabupaten berubah, kelurahan juga harus ikut di-reset
                filterDropdown(kecSelect, kelSelect, 'data-parent');
            });

            kecSelect.addEventListener('change', () => {
                filterDropdown(kecSelect, kelSelect, 'data-parent');
            });

            // Init (saat halaman pertama kali dimuat)
            updateVisibility();
            filterDropdown(kabSelect, kecSelect, 'data-parent');
            filterDropdown(kecSelect, kelSelect, 'data-parent');
        });
    </script>
</div>