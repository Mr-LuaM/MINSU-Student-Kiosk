<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINSU Student Kiosk</title>

    @vite('resources/css/app.css')

    <style>
        body {
            background-image: url("{{ asset('assets/images/minsu-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="relative h-screen flex flex-col overflow-hidden text-white">

    {{-- Background Tint Overlay (Behind Everything Except Header) --}}
    <div class="absolute inset-0 bg-gray-900 opacity-50 z-0"></div>


    {{-- Header (Ensures it’s above the overlay) --}}
    <header class="relative z-10">
        @include('partials.header')
    </header>

    {{-- Main Content (Centered & Scrollable if needed) --}}
    <main class="relative flex flex-col items-center justify-center flex-grow w-full overflow-y-auto text-center px-4 z-10">
        {{ $slot }}
    </main>

    {{-- Footer (Always at Bottom) --}}
    <footer class="relative z-10">
        @include('partials.footer')
    </footer>

    {{-- 🚀 Move Modal Here to Ensure It's on Top --}}
    @include('partials.guidelines-modal')
</body>

</html>