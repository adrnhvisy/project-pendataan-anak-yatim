<aside class="w-64 bg-white border-r min-h-screen">
    <div class="p-4 border-b font-bold text-lg">Pendataan Anak Yatim</div>
    <nav class="p-4 space-y-4">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Dashboard</a>

        {{-- Data Anak --}}
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-2">Data Anak</p>
            <a href="{{ route('anak.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('anak.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Data Anak</a>
        </div>

        {{-- Verifikasi --}}
        @role('superadmin|kesra|kecamatan')
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-2">Verifikasi</p>
            <a href="{{ route('verifikasi.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('verifikasi.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Verifikasi Data</a>
        </div>
        @endrole

        {{-- Laporan --}}
        @role('superadmin|kesra|kecamatan')
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-2">Laporan</p>
            <a href="{{ route('laporan.anak') }}" class="block px-3 py-2 rounded {{ request()->routeIs('laporan.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Laporan</a>
        </div>
        @endrole

        {{-- Master Data & Sistem --}}
        @role('superadmin')
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-2">Master Data</p>
            <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">User</a>
            <a href="{{ route('roles.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('roles.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Roles & Permission</a>
            <a href="{{ route('wilayah.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('wilayah.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Wilayah</a>
        </div>
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-2">Sistem</p>
            <a href="{{ route('sistem.audit.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('sistem.audit.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Audit Log</a>
            <a href="{{ route('pengaturan.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('pengaturan.*') ? 'bg-indigo-50 text-indigo-700' : 'hover:bg-gray-100' }}">Pengaturan</a>
        </div>
        @endrole
    </nav>
</aside>