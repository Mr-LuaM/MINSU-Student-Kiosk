<x-kiosk-layout>
    <div class="flex flex-col items-center justify-center w-full h-full text-center px-4 sm:px-6 lg:px-12">

        {{-- Search Section Title --}}
        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
            Search Student Records
        </h2>

        {{-- Search Form (Using GET to Show in URL) --}}
        <form method="GET" action="{{ route('kiosk.search') }}" id="searchForm" class="w-full max-w-6xl">

            {{-- Search Input (Keeps User Input in URL) --}}
            <div class="relative w-full">
                <input type="text" name="search" id="searchInput"
                    class="w-full px-8 sm:px-10 py-6 sm:py-8 text-2xl sm:text-3xl md:text-4xl lg:text-5xl rounded-kiosk 
                bg-white text-gray-900 placeholder-gray-700 
                focus:outline-none focus:ring-4 focus:ring-primary shadow-kiosk border-4 border-primary"
                    placeholder="Enter Name, ID, or Other Data..."
                    value="{{ request('search') }}">
            </div>

            {{-- Dropdown Filters (Keeps Selection After Search) --}}
            <div class="w-full flex flex-wrap justify-center gap-6 mt-6">
                <select name="year_level" class="w-full md:w-1/3 px-6 sm:px-8 py-4 sm:py-6 text-xl sm:text-2xl md:text-3xl bg-white text-gray-900 
                rounded-kiosk focus:outline-none focus:ring-4 focus:ring-primary shadow-kiosk border-4 border-primary">
                    <option value="">All Year Levels</option>
                    @foreach ($yearLevels as $year)
                    <option value="{{ $year }}" {{ request('year_level') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>

                <select name="student_type" class="w-full md:w-1/3 px-6 sm:px-8 py-4 sm:py-6 text-xl sm:text-2xl md:text-3xl bg-white text-gray-900 
                rounded-kiosk focus:outline-none focus:ring-4 focus:ring-primary shadow-kiosk border-4 border-primary">
                    <option value="">All Student Types</option>
                    @foreach ($studentTypes as $type)
                    <option value="{{ $type }}" {{ request('student_type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                    @endforeach
                </select>

                <select name="program" class="w-full md:w-1/3 px-6 sm:px-8 py-4 sm:py-6 text-xl sm:text-2xl md:text-3xl bg-white text-gray-900 
                rounded-kiosk focus:outline-none focus:ring-4 focus:ring-primary shadow-kiosk border-4 border-primary">
                    <option value="">All Programs</option>
                    @foreach ($programs as $program)
                    <option value="{{ $program }}" {{ request('program') == $program ? 'selected' : '' }}>
                        {{ $program }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Search Button --}}
            <button type="submit" id="searchButton"
                class="mt-8 sm:mt-10 px-14 sm:px-16 py-6 sm:py-8 text-3xl sm:text-4xl md:text-5xl font-bold bg-secondary text-gray-900 
            rounded-kiosk shadow-lg hover:shadow-xl hover:opacity-90 transition-all 
            focus:ring-4 focus:ring-white border-4 border-white">
                🔍 Search
            </button>
        </form>
    </div>
</x-kiosk-layout>