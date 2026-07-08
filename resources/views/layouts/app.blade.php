<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9ff]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @if(get_setting('logo_web'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . get_setting('logo_web')) }}">
    @elseif(get_setting('favicon'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . get_setting('favicon')) }}">
    @endif
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-[#0b1c30] h-full">
    <div class="flex min-h-screen bg-[#f8f9ff]"
        x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' }"
        x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col min-w-0 bg-[#f8f9ff]">

            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white border-b border-[#e5eeff] shadow-sm sticky top-0 z-10">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 w-full mx-auto max-w-7xl p-4 sm:p-6 lg:p-8 relative">
                <div class="absolute inset-0 flex items-center justify-center z-0 pointer-events-none opacity-5">
                    <div class="w-64 h-64">
                        @if(get_setting('logo_web'))
                            <img src="{{ asset('storage/' . get_setting('logo_web')) }}" alt="Logo"
                                class="w-full h-full object-contain">
                        @else
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-[#004ac6]">
                                <path
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        @endif
                    </div>
                </div>

                <div class="animate-in fade-in slide-in-from-bottom-4 zoom-in-95 duration-500 ease-out relative z-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Menunggu seluruh halaman HTML selesai dimuat
        document.addEventListener('DOMContentLoaded', function () {

            // Memasang 'pendengar' pada seluruh body dokumen
            document.body.addEventListener('submit', function (e) {

                // Mengecek apakah elemen yang memicu submit memiliki class 'form-hapus'
                if (e.target && e.target.classList.contains('form-hapus')) {
                    e.preventDefault(); // Menahan form agar tidak langsung terkirim

                    const form = e.target;
                    // Mencari tombol submit di dalam form tersebut
                    const button = form.querySelector('button[type="submit"]') || form.querySelector('button');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            // Jika tombol ditemukan, ubah menjadi mode loading
                            if (button) {
                                button.disabled = true;
                                // Menambahkan efek visual agar terlihat tidak aktif
                                button.classList.add('cursor-not-allowed', 'opacity-75', 'no-underline');
                                button.innerHTML = `
                                <span class="flex items-center justify-center text-red-600 font-medium">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    Menghapus...
                                </span>
                            `;
                            }

                            // Submit form secara manual
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>