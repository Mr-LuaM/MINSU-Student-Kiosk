<x-kiosk-layout>
    <div class="flex flex-col items-center w-full h-full text-center px-6">

        {{-- Search Results Title --}}
        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-default mb-6">
            Search Results
        </h2>

        {{-- Back to Search Button --}}
        <a href="{{ route('kiosk.home') }}"
            class="mb-6 px-12 py-6 text-3xl font-bold bg-secondary text-black rounded-kiosk shadow-lg hover:opacity-90 transition-all focus:ring-primary border-4 border-primary">
            ⬅ Back to Search
        </a>

        {{-- Results Display --}}
        @if($students->isEmpty())
        <p class="text-default text-3xl sm:text-4xl">No students found.</p>
        @else
        <div class="w-full max-w-6xl mx-auto grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($students as $student)
            <div class="p-6 border-4 border-primary bg-white rounded-lg shadow-md cursor-pointer transition-all duration-300
                hover:bg-secondary text-gray-900 hover:shadow-lg hover:scale-105"
                onclick=" openStudentModal('{{ $student->student_id }}')">

                {{-- Header --}}
                <div class="flex justify-between mb-4">
                    <h2 class="text-lg font-bold">{{ $student->first_name }} {{ $student->last_name }}</h2>
                    <span class="text-lg text-gray-500">{{ $student->student_id }}</span>
                </div>

                {{-- Contact --}}
                <div class="mb-4 flex flex-col gap-2 text-start">
                    <p class="text-md font-semibold text-gray-700"><span class="font-bold text-gray-900">Email:</span> {{ $student->contact->email ?? 'No Email' }}</p>
                    <p class="text-md font-semibold text-gray-700"><span class="font-bold text-gray-900">Address:</span> {{ $student->contact->address ?? 'No Address' }}</p>
                </div>


                {{-- Academics --}}
                <div class="flex flex-wrap justify-end gap-3 pt-5">
                    <span class="px-4 py-2 rounded-full bg-primary text-white  font-semibold">
                        Year: {{ $student->academics->year_level ?? 'N/A' }}
                    </span>
                    <span class="px-4 py-2 rounded-full bg-primary text-white  font-semibold">
                        {{ $student->academics->program ?? 'N/A' }}
                    </span>
                    <span class="px-4 py-2 rounded-full bg-primary text-white  font-semibold">
                        {{ $student->student_type }}
                    </span>
                </div>

            </div>
            @endforeach
        </div>


        {{-- Pagination --}}
        <div class="mt-6">
            {{ $students->links() }}
        </div>
        @endif
    </div>

    {{-- 🚀 Full-Screen Scrollable Modal with Better Colors --}}
    <div id="studentModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden">
        <div class="bg-modal w-full max-w-4xl p-8 sm:p-12 rounded-lg shadow-2xl border-4 border-primary overflow-y-auto max-h-[85vh] relative">

            {{-- Close Button (Fix Color) --}}
            <button class="absolute top-4 right-4 text-4xl font-bold text-red-600 "
                onclick="closeStudentModal()">
                X
            </button>
            {{-- 🎓 Student Name --}}
            <h2 class="text-4xl font-bold mb-2 text-primary" id="modalStudentName"></h2>
            <p class="text-lg text-gray-600 mb-6" id="modalStudentID"></p>

            <div class="space-y-6">
                {{-- 🏷️ Personal Information --}}
                <div class="bg-gray-100 border border-primary shadow-md p-6 rounded-lg">
                    <h3 class="text-2xl font-bold text-primary mb-4">Personal Information</h3>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-lg text-gray-800">
                        <div><strong>Birth Date:</strong> <span id="modalBirthDate"></span></div>
                        <div><strong>Gender:</strong> <span id="modalGender"></span></div>
                        <div><strong>Nationality:</strong> <span id="modalNationality"></span></div>
                        <div><strong>Religion:</strong> <span id="modalReligion"></span></div>
                        <div><strong>Blood Type:</strong> <span id="modalBloodType"></span></div>
                        <div><strong>Student Type:</strong> <span id="modalStudentType"></span></div>
                    </div>
                </div>

                {{-- 🎓 Academic Information --}}
                <div class="bg-gray-100 border border-primary shadow-md p-6 rounded-lg">
                    <h3 class="text-2xl font-bold text-primary mb-4">Academic Information</h3>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-lg text-gray-800">
                        <div><strong>Year Level:</strong> <span id="modalYearLevel"></span></div>
                        <div><strong>Program:</strong> <span id="modalProgram"></span></div>
                        <div><strong>College:</strong> <span id="modalCollege"></span></div>
                        <div><strong>Section:</strong> <span id="modalSection"></span></div>
                        <div><strong>GWA:</strong> <span id="modalGWA"></span></div>
                        <div><strong>Enrollment Status:</strong> <span id="modalEnrollmentStatus"></span></div>
                    </div>
                </div>

                {{-- 📞 Contact Information --}}
                <div class="bg-gray-100 border border-primary shadow-md p-6 rounded-lg">
                    <h3 class="text-2xl font-bold text-primary mb-4">Contact Information</h3>
                    <hr class="border-t border-gray-300 mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-lg text-gray-800">
                        <div><strong>Email:</strong> <span id="modalEmail"></span></div>
                        <div><strong>Phone:</strong> <span id="modalPhone"></span></div>
                        <div><strong>Guardian Name:</strong> <span id="modalGuardian"></span></div>
                        <div><strong>Guardian Contact:</strong> <span id="modalGuardianContact"></span></div>
                        <div><strong>Emergency Contact:</strong> <span id="modalEmergency"></span></div>
                        <div><strong>Address:</strong> <span id="modalAddress"></span></div>
                    </div>
                </div>

                {{-- 🛠️ Skills --}}
                <div class="bg-gray-100 border border-primary shadow-md p-6 rounded-lg">
                    <h3 class="text-2xl font-bold text-primary mb-4">Skills</h3>
                    <hr class="border-t border-gray-300 mb-4">
                    <ul id="modalSkills" class="list-disc ml-6 text-lg text-gray-800 space-y-1"></ul>
                </div>

                {{-- 🏆 Achievements --}}
                <div class="bg-gray-100 border border-primary shadow-md p-6 rounded-lg">
                    <h3 class="text-2xl font-bold text-primary mb-4">Achievements</h3>
                    <hr class="border-t border-gray-300 mb-4">
                    <ul id="modalAchievements" class="list-disc ml-6 text-lg text-gray-800 space-y-1"></ul>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for Opening and Closing Modal --}}
    <script>
        function openStudentModal(studentID) {
            let studentData = @json($students);
            let student = studentData.data.find(s => s.student_id === studentID);

            if (!student) return;

            document.getElementById("modalStudentName").innerText = student.first_name + " " + student.last_name;
            document.getElementById("modalStudentID").innerText = "Student ID: " + student.student_id;
            document.getElementById("modalBirthDate").innerText = student.birth_date ?? 'N/A';
            document.getElementById("modalGender").innerText = student.gender ?? 'N/A';
            document.getElementById("modalNationality").innerText = student.nationality ?? 'N/A';
            document.getElementById("modalReligion").innerText = student.religion ?? 'N/A';
            document.getElementById("modalBloodType").innerText = student.blood_type ?? 'N/A';
            document.getElementById("modalStudentType").innerText = student.student_type ?? 'N/A';

            document.getElementById("modalYearLevel").innerText = student.academics?.year_level ?? 'N/A';
            document.getElementById("modalProgram").innerText = student.academics?.program ?? 'N/A';
            document.getElementById("modalCollege").innerText = student.academics?.college ?? 'N/A';
            document.getElementById("modalSection").innerText = student.academics?.section ?? 'N/A';
            document.getElementById("modalGWA").innerText = student.academics?.gwa ?? 'N/A';
            document.getElementById("modalEnrollmentStatus").innerText = student.academics?.enrollment_status ?? 'N/A';

            document.getElementById("modalAddress").innerText = student.contact?.address ?? 'N/A';
            document.getElementById("modalPhone").innerText = student.contact?.phone_number ?? 'N/A';
            document.getElementById("modalEmail").innerText = student.contact?.email ?? 'N/A';
            document.getElementById("modalGuardian").innerText = student.contact?.guardian_name ?? 'N/A';
            document.getElementById("modalGuardianContact").innerText = student.contact?.guardian_contact ?? 'N/A';
            document.getElementById("modalEmergency").innerText = student.contact?.emergency_contact ?? 'N/A';

            // Skills
            let skillsList = document.getElementById("modalSkills");
            skillsList.innerHTML = "";
            if (student.skills && student.skills.length > 0) {
                student.skills.forEach(skill => {
                    let li = document.createElement("li");
                    li.innerText = `${skill.skill_name} (${skill.proficiency_level})`;
                    skillsList.appendChild(li);
                });
            } else {
                skillsList.innerHTML = "<li>No skills listed.</li>";
            }

            // Achievements
            let achievementsList = document.getElementById("modalAchievements");
            achievementsList.innerHTML = "";
            if (student.achievements && student.achievements.length > 0) {
                student.achievements.forEach(achievement => {
                    let li = document.createElement("li");
                    li.innerText = `${achievement.achievement_name} - ${achievement.category} (${achievement.award_date})`;
                    achievementsList.appendChild(li);
                });
            } else {
                achievementsList.innerHTML = "<li>No achievements listed.</li>";
            }

            document.getElementById("studentModal").classList.remove("hidden");
        }

        function closeStudentModal() {
            document.getElementById("studentModal").classList.add("hidden");
        }
    </script>

</x-kiosk-layout>