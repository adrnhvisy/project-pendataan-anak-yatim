<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50 relative overflow-hidden">

        <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(#64748b 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div
            class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/80 backdrop-blur-sm border border-slate-200 shadow-2xl shadow-slate-200/50 sm:rounded-3xl relative z-10 animate-in fade-in zoom-in duration-500 ease-out">

            {{ $slot }}
        </div>

        <div class="mt-8 text-slate-400 text-xs z-10">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}
        </div>
    </div>
</body>

</html>