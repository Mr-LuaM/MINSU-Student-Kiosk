{{-- 📜 Modal Overlay --}}
<div id="guidelinesModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[9999] hidden">
    {{-- 📌 Modal Content (Scrollable) --}}
    <div class="bg-modal text-gray-900 max-w-3xl w-full p-6 sm:p-8 md:p-10 rounded-lg relative shadow-2xl border-4 border-primary max-h-[90vh] overflow-y-auto">

        {{-- 🔖 Modal Header --}}
        <div class="flex justify-between items-center mb-4 sm:mb-6">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary">📜 Kiosk Guidelines</h2>
            <button onclick="closeModal()" class="text-gray-600 hover:text-red-700 text-3xl sm:text-4xl font-bold">&times;</button>
        </div>

        {{-- 📌 Updated Guidelines Content (Responsive) --}}
        <div class="text-base sm:text-lg md:text-xl leading-relaxed text-gray-800">
            <p>Welcome to the <span class="text-primary font-bold">MINSU Student Kiosk</span>. Follow these steps:</p>
            <ul class="mt-4 space-y-3 sm:space-y-4 text-left">
                <li>✅ <span class="text-secondary font-bold">Search Students:</span> Enter a **student’s name, ID, or personal detail** (e.g., birth date, gender, nationality).</li>
                <li>✅ <span class="text-secondary font-bold">Filter by Academics:</span> Search using **Year Level, Student Type, or Program** to refine results.</li>
                <li>✅ <span class="text-secondary font-bold">View Complete Profile:</span> Click on a student to see **contact details, academic records, skills, and achievements**.</li>
                <li>✅ <span class="text-secondary font-bold">Find Contact Details:</span> Get **email, phone, address, and guardian contact** information.</li>
                <li>✅ <span class="text-secondary font-bold">Check Skills & Achievements:</span> View a student’s **listed skills** and **awards in academics, sports, arts, or technology**.</li>
            </ul>
        </div>

        {{-- 🔑 Admin Login Link --}}
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-primary font-bold text-lg sm:text-xl hover:text-accent transition-all">
                🔑 Admin Login
            </a>
        </div>


        {{-- ❌ Close Button --}}
        <div class="mt-6 text-center">
            <button onclick="closeModal()" class="bg-primary text-white font-bold px-5 py-3 sm:px-6 sm:py-3 rounded-lg hover:bg-green-700 transition-all shadow-md text-lg sm:text-xl">
                Close
            </button>
        </div>
    </div>
</div>

{{-- 🛠️ JavaScript for Modal Functionality --}}
<script>
    function openModal() {
        document.getElementById('guidelinesModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('guidelinesModal').classList.add('hidden');
    }
</script>