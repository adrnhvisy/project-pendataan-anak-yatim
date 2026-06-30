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
    <div class="flex min-h-screen bg-[#f8f9ff]">

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
                    <div class="w-64 h-64"> @if(get_setting('logo_web'))
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
</body>

</html>