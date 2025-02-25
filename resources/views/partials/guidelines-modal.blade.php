{{-- 📜 Modal Overlay (Closes on Background Click) --}}
<div id="guidelinesModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[9999] hidden" onclick="closeModal(event)">
    {{-- 📌 Modal Content (More Spacing, Cleaner UI) --}}
    <div class="bg-modal text-gray-900 max-w-2xl w-full p-6 md:p-8 rounded-lg relative shadow-lg border-2 md:border-4 border-primary max-h-[85vh] overflow-y-auto">

        {{-- 🔖 Modal Header (Title & Close Button) --}}
        <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-3">
            <h2 class="text-xl md:text-2xl font-bold text-primary">📜 Kiosk Guidelines</h2>
            <button onclick="closeModal(event)" class="text-gray-800 hover:text-red-700 text-2xl md:text-3xl font-bold">
                &times;
            </button>
        </div>
        {{-- 📌 Welcome Message --}}
        <div class="text-sm md:text-lg leading-relaxed text-gray-800 max-w-2xl mx-auto mb-4">
            <p>Welcome to the <span class="text-primary font-bold">MINSU Student Kiosk</span>. Follow these simple steps:</p>
        </div>
        {{-- 📌 Guidelines Content (Title + Function Sections) --}}
        <div class="text-sm md:text-lg leading-relaxed text-gray-800 max-w-2xl mx-auto">

            {{-- ✅ Section 1: Search Functionality --}}
            <div class="mt-4 border-t border-gray-300 pt-4">
                <h3 class="text-secondary-darken font-bold text-lg md:text-xl mb-2">🔍 Search for Students</h3>
                <p>Enter a <strong>student’s name, ID, or birthdate</strong> to find their profile.</p>
            </div>

            {{-- ✅ Section 2: Filtering --}}
            <div class="mt-4 border-t border-gray-300 pt-4">
                <h3 class="text-secondary-darken font-bold text-lg md:text-xl mb-2">🎯 Filter by Academics</h3>
                <p>Refine search results by selecting a <strong>Year Level, Student Type, or Program</strong>.</p>
            </div>

            {{-- ✅ Section 3: Profile Viewing --}}
            <div class="mt-4 border-t border-gray-300 pt-4">
                <h3 class="text-secondary-darken font-bold text-lg md:text-xl mb-2">📁 View Student Profiles</h3>
                <p>See details like <strong>contact information, academic records, skills, and achievements</strong>.</p>
            </div>

            {{-- ✅ Section 4: Contact Information --}}
            <div class="mt-4 border-t border-gray-300 pt-4">
                <h3 class="text-secondary-darken font-bold text-lg md:text-xl mb-2">📞 Find Contact Details</h3>
                <p>Get a student's <strong>email, phone, address, and guardian contact</strong> information.</p>
            </div>

            {{-- ✅ Section 5: Achievements --}}
            <div class="mt-4 border-t border-gray-300 pt-4">
                <h3 class="text-secondary-darken font-bold text-lg md:text-xl mb-2">🏆 Check Skills & Achievements</h3>
                <p>View a student’s <strong>skills and awards</strong> in academics, sports, arts, or technology.</p>
            </div>

        </div>

        {{-- 🔑 Admin Login Link (Now More Subtle) --}}
        <div class="mt-6 text-center border-t border-gray-300 pt-4">
            <a href="{{ route('login') }}" class="text-primary font-bold text-lg hover:text-accent transition">
                🔑 Admin Login
            </a>
        </div>

        {{-- ❌ Close Button (More Space, Less Dense) --}}
        <div class="mt-6 flex justify-center">
            <button onclick="closeModal(event)" class="bg-primary text-white font-bold px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-md text-lg">
                Close
            </button>
        </div>
    </div>
</div>

{{-- 🛠️ JavaScript for Modal Functionality (Same as Before) --}}
<script>
    function openModal() {
        document.getElementById('guidelinesModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('guidelinesModal').classList.add('hidden');
    }

    // ✅ Close modal when pressing "Esc" key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal(event);
        }
    });
</script>