<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[20px] shadow-sm overflow-hidden border border-gray-100 animate-in fade-in slide-in-from-bottom-4 duration-500 ease-out">
                
                <div class="h-40 relative" style="background-color: #233142; background-image: radial-gradient(#3a4a5e 1px, transparent 1px); background-size: 20px 20px;">
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <div class="w-24 h-24 rounded-2xl bg-white p-1 shadow-lg flex items-center justify-center">
                            <div class="w-full h-full rounded-xl bg-blue-50 border border-gray-100 flex items-center justify-center text-blue-600 text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-16 px-12 pb-12">
                    
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-slate-900 mb-4">{{ $user->name }}</h2>
                        <div class="flex items-center justify-center gap-3">
                            <span class="px-3 py-1.5 border border-blue-600 text-blue-600 text-[10px] font-bold rounded-lg flex items-center gap-1.5 uppercase">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                {{ $user->roles->first()?->name ?? 'User' }}
                            </span>
                            
                            @if(isset($user->is_active))
                                <span class="px-3 py-1.5 {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} text-[10px] font-bold rounded-lg flex items-center gap-1.5 uppercase">
                                    <span class="w-1.5 h-1.5 {{ $user->is_active ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full animate-pulse"></span>
                                    {{ $user->is_active ? 'Status Aktif' : 'Nonaktif' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="border-slate-100 mb-10"/>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12 mb-12">
                        <div>
                            <div class="flex items-center gap-2 mb-2 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <p class="text-[10px] font-bold uppercase tracking-widest">Nama Lengkap</p>
                            </div>
                            <p class="text-lg font-semibold text-slate-800">{{ $user->name }}</p>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-2 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <p class="text-[10px] font-bold uppercase tracking-widest">Alamat Email</p>
                            </div>
                            <p class="text-lg font-semibold text-slate-800">{{ $user->email }}</p>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-2 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-[10px] font-bold uppercase tracking-widest">Akun Dibuat Pada</p>
                            </div>
                            <p class="text-lg font-semibold text-slate-800">{{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }}</p>
                        </div>

                        @if(isset($user->provinsi))
                        <div>
                            <div class="flex items-center gap-2 mb-2 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path></svg>
                                <p class="text-[10px] font-bold uppercase tracking-widest">Wilayah Tugas</p>
                            </div>
                            <p class="text-lg font-semibold text-slate-800">{{ $user->provinsi->name }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 flex items-start gap-4">
                        <svg class="h-6 w-6 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Anda login sebagai <span class="font-bold text-slate-700 italic">{{ $user->roles->first()?->name ?? 'User' }}</span>. Sesuai dengan kebijakan sistem, segala bentuk perubahan pada profil hanya dapat diproses melalui pengajuan kepada Administrator Sistem (Superadmin).
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>