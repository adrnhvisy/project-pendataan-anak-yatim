<aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white border-r border-slate-200 h-screen flex flex-col sticky top-0 z-50 shadow-sm transition-all duration-300">
    <div class="px-6 py-6 border-b border-slate-100">
        <div class="flex items-center gap-3" :class="sidebarOpen ? '' : 'justify-center ml-[-12px]'">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-200 overflow-hidden shrink-0">
                @if(get_setting('logo_web'))
                    <img src="{{ asset('storage/' . get_setting('logo_web')) }}" alt="Logo" class="w-full h-full object-cover">
                @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                @endif
            </div>

            <div class="overflow-hidden" x-show="sidebarOpen" style="display: none;" x-transition>
                <h1 class="text-sm font-bold text-slate-800 truncate leading-tight">
                    {{ get_setting('nama_aplikasi', 'SAHABAT') }}
                </h1>
                <p class="text-[9px] text-slate-500 uppercase tracking-widest font-bold mt-0.5">
                    {{ get_setting('nama_panjang_aplikasi', 'Sistem Hibah Yatim') }}
                </p>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-8 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">

        <div>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Dashboard">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-sm font-semibold whitespace-nowrap" x-show="sidebarOpen">Dashboard</span>
            </a>
        </div>

        <div class="space-y-4">
            @role('kesra|kecamatan|pendamping')
            <div>
                <p x-show="sidebarOpen" class="text-[10px] font-bold uppercase text-slate-400 px-3 mb-2 tracking-widest whitespace-nowrap">Data & Verifikasi</p>
                <div class="space-y-1">
                    <a href="{{ route('anak.index') }}"
                        class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('anak.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                        :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Data Anak">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Data Anak</span>
                    </a>
                    @role('kesra')
                    <a href="{{ route('verifikasi.index') }}"
                        class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('verifikasi.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                        :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Verifikasi Data">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Verifikasi Data</span>
                    </a>
                    @endrole
                </div>
            </div>
            @endrole

            @role('kesra|kecamatan|pendamping')
            <div>
                <p x-show="sidebarOpen" class="text-[10px] font-bold uppercase text-slate-400 px-3 mb-2 tracking-widest mt-4 whitespace-nowrap">Analitik</p>
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('laporan.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Laporan">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Laporan</span>
                </a>
            </div>
            @endrole
        </div>

        @role('superadmin')
        <div class="space-y-4">
            <p x-show="sidebarOpen" class="text-[10px] font-bold uppercase text-slate-400 px-3 mb-2 tracking-widest mt-4 whitespace-nowrap">Administrasi</p>
            <div class="space-y-1">
                <a href="{{ route('users.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="User Management">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">User Management</span>
                </a>
                <a href="{{ route('roles.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('roles.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Roles & Permission">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Roles & Permission</span>
                </a>
                <a href="{{ route('wilayah.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('wilayah.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Wilayah">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0 transition-colors">
                        <path d="M12 18L6 15.9L1.35 17.7C1.01667 17.8333 0.708333 17.7958 0.425 17.5875C0.141667 17.3792 0 17.1 0 16.75V2.75C0 2.53333 0.0625 2.34167 0.1875 2.175C0.3125 2.00833 0.483333 1.88333 0.7 1.8L6 0L12 2.1L16.65 0.3C16.9833 0.166667 17.2917 0.204167 17.575 0.4125C17.8583 0.620833 18 0.9 18 1.25V15.25C18 15.4667 17.9375 15.6583 17.8125 15.825C17.6875 15.9917 17.5167 16.1167 17.3 16.2L12 18ZM11 15.55V3.85L7 2.45V14.15L11 15.55Z" fill="currentColor" />
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Wilayah</span>
                </a>
                <a href="{{ route('kategori-dokumen.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('kategori-dokumen.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Dokumen Kategori">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Dokumen Kategori</span>
                </a>
                <a href="{{ route('audit.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('audit.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Audit Log">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Audit Log</span>
                </a>
                <a href="{{ route('pengaturan.index') }}"
                    class="flex items-center gap-3 py-2 rounded-lg transition-colors {{ request()->routeIs('pengaturan.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                    :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'" title="Pengaturan">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    </svg>
                    <span class="text-sm whitespace-nowrap" x-show="sidebarOpen">Pengaturan</span>
                </a>
            </div>
        </div>
        @endrole
    </nav>

    <div class="p-4 border-t border-slate-100 bg-slate-50 relative overflow-hidden transition-all duration-300">
        <div class="absolute inset-0 flex items-center justify-center z-0 opacity-5 pointer-events-none">
            <div class="w-20 h-20">
                @if(get_setting('logo_web'))
                    <img src="{{ asset('storage/' . get_setting('logo_web')) }}" alt="Logo"
                        class="w-full h-full object-contain">
                @else
                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-slate-800">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                @endif
            </div>
        </div>

        <div class="relative z-10 flex items-center gap-3" :class="sidebarOpen ? '' : 'justify-center ml-[-12px]'">
            <div
                class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold border-2 border-white shadow-sm ring-1 ring-black/5 shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden" x-show="sidebarOpen" style="display: none;" x-transition>
                <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-wide font-bold">
                    {{ Auth::user()->roles->first()->name ?? 'User' }}
                </p>
            </div>
        </div>
    </div>
</aside>