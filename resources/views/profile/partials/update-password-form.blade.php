<section>
    <header class="mb-8">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            Keamanan Password
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Pastikan akun Anda menggunakan password yang panjang dan acak untuk menjaga keamanan data pemerintahan.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700 mb-1">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-colors text-sm py-2.5 px-3">
            @error('current_password')
                <p class="text-sm text-red-600 mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-slate-700 mb-1">Password Baru</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-colors text-sm py-2.5 px-3">
            @error('password')
                <p class="text-sm text-red-600 mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-colors text-sm py-2.5 px-3">
            @error('password_confirmation')
                <p class="text-sm text-red-600 mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-slate-800 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-wider hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-green-600 font-semibold flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Password Diperbarui.
                </p>
            @endif
        </div>
    </form>
</section>