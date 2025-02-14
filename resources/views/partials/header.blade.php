<header class="w-full flex items-center justify-between p-3 md:p-4 bg-transparent">
    <div class="flex items-center space-x-2 md:space-x-3">
        {{-- MinSU Logo (Responsive Size) --}}
        <img src="{{ asset('assets/images/minsu-logo.png') }}" alt="MinSU Logo" class="h-10 md:h-12 lg:h-14">

        {{-- Title (Adaptive Sizing for Small Screens) --}}
        <h1 class="text-lg sm:text-xl md:text-3xl lg:text-4xl font-extrabold text-white">
            MINSU <span class="text-secondary">Student Kiosk</span>
        </h1>
    </div>

    {{-- Info Icon (Circular Background for Better Visibility) --}}
    <button onclick="openModal()" class="focus:outline-none p-1 md:p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 sm:h-8 md:h-10 lg:h-12 w-6 sm:w-8 md:w-10 lg:w-12 text-white"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m0-4h.01M12 21h.01M12 3h.01" />
        </svg>
    </button>
</header>

<!-- {{-- Include the Guidelines Modal --}}nilagay na sa app.layout
@include('partials.guidelines-modal') -->