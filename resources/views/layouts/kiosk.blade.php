<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINSU Student Kiosk</title>

    @vite('resources/css/app.css')

</head>

<body class="relative h-screen flex flex-col overflow-hidden text-white bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('assets/images/minsu-bg.jpg') }}');">

    <livewire:toasts />

    {{-- Background Tint Overlay (Ensures better text readability) --}}
    <div class="absolute inset-0 bg-gray-900 opacity-50 -z-10"></div>

    {{-- Header (Ensures it’s above the overlay) --}}
    <header class="relative z-10">
        @include('partials.header')
    </header>

    {{-- Main Content (Centered & Scrollable if needed) --}}
    <main class="relative flex flex-col items-center justify-center flex-grow w-full overflow-y-auto text-center px-4 lg:px-8 max-w-screen-xl mx-auto z-10">
        {{ $slot }}
    </main>

    {{-- Footer (Always at Bottom) --}}
    <footer class="relative z-10">
        @include('partials.footer')
    </footer>

    {{-- 🚀 Move Modal Here to Ensure It's on Top --}}
    <div class="relative z-50">
        @include('partials.guidelines-modal')
    </div>

    <script>
        let idleTime = 0;
        const idleLimit = 5 * 60; // 5 minutes (300 seconds)
        const idleRedirectUrl = "{{ config('app.idle_redirect_url') }}"; // Get URL from Laravel config

        function resetIdleTimer() {
            // Reset the timer only if the user is NOT already on the idle page
            if (window.location.href !== idleRedirectUrl) {
                idleTime = 0;
            }
        }

        function startIdleTimer() {
            setInterval(() => {
                // If already on the idle page, do nothing
                if (window.location.href === idleRedirectUrl) {
                    return;
                }

                idleTime++;

                // Redirect only if not already on the idle page
                if (idleTime >= idleLimit) {
                    window.location.href = idleRedirectUrl;
                }
            }, 1000); // Check every second
        }

        // Reset timer on user interactions
        document.addEventListener("mousemove", resetIdleTimer);
        document.addEventListener("keypress", resetIdleTimer);
        document.addEventListener("click", resetIdleTimer);
        document.addEventListener("touchstart", resetIdleTimer);
        document.addEventListener("scroll", resetIdleTimer);

        // Start the idle timer when the page loads
        window.onload = () => {
            if (window.location.href !== idleRedirectUrl) {
                startIdleTimer();
            }
        };
    </script>


</body>

</html>