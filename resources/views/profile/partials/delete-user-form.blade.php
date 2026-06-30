<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-600 flex items-center gap-2">
            Hapus Akun Permanen
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
        class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-red-600 rounded-lg font-bold text-xs text-red-600 uppercase tracking-wider hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
        Hapus Akun
    </button>

    <div x-data="{ show: false, name: 'confirm-user-deletion' }"
        x-show="show"
        x-on:open-modal.window="if ($event.detail === name) { show = true; setTimeout(() => $refs.password.focus(), 50) }"
        x-on:close-modal.window="if ($event.detail === name) show = false"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false"
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" 
            x-on:click="show = false"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h2 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">
                                    Apakah Anda yakin ingin menghapus akun?
                                </h2>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 mb-4">
                                        Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan password Anda untuk mengonfirmasi.
                                    </p>
                                    
                                    <div>
                                        <label for="password" class="sr-only">Password</label>
                                        <input x-ref="password" type="password" name="password" id="password" placeholder="Masukkan Password Anda"
                                            class="w-full border-slate-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 transition-colors text-sm py-2.5 px-3">
                                        @error('password', 'userDeletion')
                                            <p class="text-sm text-red-600 mt-2 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-red-600 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto transition-colors">
                            Hapus Akun
                        </button>
                        <button type="button" x-on:click="show = false" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>