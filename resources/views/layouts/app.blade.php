<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MINSU Student Kiosk') }}</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Background Styling -->
    <style>
        /* Fixed Background Image */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('assets/images/minsu-bg.jpg') }}") no-repeat center center;
            background-size: cover;
            z-index: -2;
        }

        /* Tint Overlay */
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            /* Adjust opacity for better contrast */
            z-index: -1;
        }
    </style>
</head>

<body class="font-sans antialiased relative flex flex-col min-h-screen text-white">

    {{-- Navigation Bar (Ensures it's above the overlay) --}}
    <header class="relative z-50">
        @include('layouts.navigation')
    </header>

    {{-- Page Heading --}}
    @isset($header)
    <header class="bg-white dark:bg-gray-800 shadow relative z-10">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
    @endisset

    {{-- Main Content (Scrollable) --}}
    <main class="relative z-10 flex-grow overflow-auto px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    {{-- Footer (Always at Bottom) --}}
    <footer class="relative z-10">
        @include('partials.footer')
    </footer>

    {{-- Include Modal (Ensures it's always on top) --}}
    @include('partials.guidelines-modal')

</body>

</html>