<x-kiosk-layout>
    <div class="relative flex flex-col items-center justify-center h-screen text-white text-center px-6">

        {{-- Centered Content (Optimized for Kiosks) --}}
        <div class="relative z-10 max-w-3xl px-6 md:px-8 animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg tracking-wide">
                WELCOME
            </h1>
            <h2 class="text-2xl md:text-3xl text-white font-semibold mt-3 tracking-wide">
                to
            </h2>
            <h2 class="text-2xl md:text-3xl text-secondary font-semibold mt-2 tracking-wide">
                MINSU Student Kiosk
            </h2>

            {{-- Description (More Readable) --}}
            <p class="text-lg md:text-xl lg:text-2xl mt-6 opacity-90 leading-relaxed">
                Find student information quickly and easily.
            </p>

            {{-- Call to Action (More Balanced Size) --}}
            <p id="continue-text" class="text-2xl md:text-4xl font-semibold mt-10 text-white 
           bg-gray-900 bg-opacity-75 px-8 py-4 rounded-xl shadow-md animate-pulse">
                Press any key or touch the screen to continue...
            </p>
        </div>

    </div>

    {{-- JavaScript to Detect Key Press or Touch --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const continueText = document.getElementById("continue-text");

            function goToHome() {
                continueText.textContent = "Loading...";
                continueText.classList.add("opacity-50", "transition-opacity", "duration-500"); // Smooth fade-out
                setTimeout(() => {
                    window.location.href = "{{ route('kiosk.home') }}";
                }, 300);
            }

            document.addEventListener("keydown", goToHome);
            document.addEventListener("pointerdown", goToHome); // Faster response
        });
    </script>

</x-kiosk-layout>