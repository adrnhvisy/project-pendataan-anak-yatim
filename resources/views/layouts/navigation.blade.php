<nav x-data="{ open: false, profileOpen: false }"
    class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-[#e5eeff] h-[72px]">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 h-full flex justify-between items-center">

        <div class="flex items-center gap-6">

            <button @click="sidebarOpen = !sidebarOpen"
                class="p-2 -ml-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>

                    <path x-show="sidebarOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="flex items-center gap-2">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-200 overflow-hidden shrink-0">
                    @if(get_setting('logo_web'))
                        <img src="{{ asset('storage/' . get_setting('logo_web')) }}" alt="Logo"
                            class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    @endif
                </div>
                <div class="hidden lg:block">
                    <h1 class="text-xs font-bold text-[#0b1c30] leading-none">
                        {{ get_setting('nama_aplikasi', 'SAHABAT') }}
                    </h1>
                    <p class="text-[9px] text-[#737686] uppercase tracking-wider font-semibold">Anak Yatim</p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-2 text-sm text-[#737686]">
                <a href="{{ route('dashboard') }}" class="hover:text-[#004ac6] transition-colors">Dashboard</a>

                @if(!request()->routeIs('dashboard'))
                    <span class="text-[#c3c6d7]">/</span>
                    @if(request()->routeIs('anak.*')) <span class="font-semibold text-[#0b1c30]">Data Anak</span>
                    @elseif(request()->routeIs('verifikasi.*')) <span class="font-semibold text-[#0b1c30]">Verifikasi</span>
                    @elseif(request()->routeIs('laporan.*')) <span class="font-semibold text-[#0b1c30]">Laporan</span>
                    @elseif(request()->routeIs('users.*')) <span class="text-[#737686]">Master Data</span> <span
                        class="text-[#c3c6d7]">/</span> <span class="font-semibold text-[#0b1c30]">Users</span>
                    @elseif(request()->routeIs('roles.*')) <span class="text-[#737686]">Master Data</span> <span
                        class="text-[#c3c6d7]">/</span> <span class="font-semibold text-[#0b1c30]">Roles</span>
                    @elseif(request()->routeIs('wilayah.*')) <span class="text-[#737686]">Master Data</span> <span
                        class="text-[#c3c6d7]">/</span> <span class="font-semibold text-[#0b1c30]">Wilayah</span>
                    @elseif(request()->routeIs('kategori-dokumen.*')) <span class="text-[#737686]">Master Data</span> <span
                        class="text-[#c3c6d7]">/</span> <span class="font-semibold text-[#0b1c30]">Kategori</span>
                    @elseif(request()->routeIs('audit.*')) <span class="text-[#737686]">Sistem</span> <span
                        class="text-[#c3c6d7]">/</span> <span class="font-semibold text-[#0b1c30]">Audit Log</span>
                    @elseif(request()->routeIs('pengaturan.*')) <span class="text-[#737686]">Sistem</span> <span
                        class="text-[#c3c6d7]">/</span> <span class="font-semibold text-[#0b1c30]">Pengaturan</span>
                    @endif
                @endif
            </div>
        </div>

        <div class="relative" x-data="{ open: false, loadingProfile: false, loadingLogout: false }"
            @click.outside="open = false">

            <button @click="open = !open"
                class="flex items-center gap-3 p-1 pr-3 rounded-full hover:bg-[#eff4ff] transition-all duration-200 focus:outline-none">
                <div
                    class="w-9 h-9 rounded-full bg-[#004ac6] flex items-center justify-center text-white font-bold text-sm shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-xs font-bold text-[#0b1c30]">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-[#004ac6] font-semibold uppercase tracking-wider">
                        {{ Auth::user()->roles->first()?->name ?? 'User' }}
                    </p>
                </div>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-[#e5eeff] py-1 z-50">

                <div class="px-4 py-2 border-b border-[#f1f5f9]">
                    <p class="text-xs text-[#737686]">Akun Saya</p>
                </div>

                <a href="{{ route('profile.index') }}" @click="loadingProfile = true"
                    :class="loadingProfile ? 'opacity-75 cursor-wait' : 'hover:bg-[#eff4ff] hover:text-[#004ac6]'"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-[#434655] transition-all duration-200">

                    <svg x-show="loadingProfile" class="animate-spin h-4 w-4 text-[#004ac6]" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>

                    <svg x-show="!loadingProfile" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>

                    <span x-text="loadingProfile ? 'Membuka...' : 'Profile'"></span>
                </a>

                <form method="POST" action="{{ route('logout') }}" @submit="loadingLogout = true">
                    @csrf
                    <button type="submit" :disabled="loadingLogout"
                        :class="loadingLogout ? 'opacity-75 cursor-not-allowed' : 'hover:bg-red-50'"
                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 transition-all duration-200">

                        <svg x-show="loadingLogout" class="animate-spin h-4 w-4 text-red-600" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>

                        <svg x-show="!loadingLogout" class="w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>

                        <span x-text="loadingLogout ? 'Keluar...' : 'Logout'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>