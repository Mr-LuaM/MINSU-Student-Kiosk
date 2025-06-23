<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="MINSU Student Kiosk">
    <meta name="description" content="Find student information quickly and easily at MINSU. A modern and user-friendly student kiosk system.">
    <link rel="icon" href="{{ asset('assets/images/minsu-logo.png') }}" type="image/png">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Background Image */
        body {
            background-image: url("{{ asset('assets/images/minsu-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="relative font-sans text-gray-900 antialiased">
    <!-- <livewire:toasts /> -->

    <!-- Background Tint Overlay (Behind Everything) -->
    <div class="absolute inset-0 bg-gray-900 opacity-50 z-0"></div>

    <!-- Main Container (Content Above the Background) -->
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <x-application-logo class="w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 relative z-10" />
            </a>
        </div>

        <div class="relative z-10 w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>


</body>

</html>