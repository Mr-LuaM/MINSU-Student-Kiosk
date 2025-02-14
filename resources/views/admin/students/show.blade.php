<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Student Profile</h1>
            <a href="{{ route('admin.students.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                ← Back to Students
            </a>
        </div>

        <!-- Student Information Card -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }} {{ $student->suffix ?? '' }}</p>
                <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
                <p><strong>Birth Date:</strong> {{ $student->birth_date }}</p>
                <p><strong>Gender:</strong> {{ $student->gender }}</p>
                <p><strong>Nationality:</strong> {{ $student->nationality }}</p>
                <p><strong>Blood Type:</strong> {{ $student->blood_type ?? 'N/A' }}</p>
                <p><strong>Religion:</strong> {{ $student->religion ?? 'N/A' }}</p>
                <p><strong>Student Type:</strong> {{ $student->student_type }}</p>
            </div>
        </div>

        <!-- Academic Details -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Academic Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <p><strong>Program:</strong> {{ optional($student->academics)->program ?? 'N/A' }}</p>
                <p><strong>Year Level:</strong> {{ optional($student->academics)->year_level ?? 'N/A' }}</p>
                <p><strong>Section:</strong> {{ optional($student->academics)->section ?? 'N/A' }}</p>
                <p><strong>Student Number:</strong> {{ optional($student->academics)->student_number ?? 'N/A' }}</p>
                <p><strong>General Weighted Average (GWA):</strong> {{ optional($student->academics)->gwa ?? 'N/A' }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="px-3 py-1 text-sm font-medium rounded-lg 
                        @if(optional($student->academics)->enrollment_status === 'Enrolled') bg-green-500 text-white
                        @elseif(optional($student->academics)->enrollment_status === 'Dropped') bg-red-600 text-white
                        @elseif(optional($student->academics)->enrollment_status === 'Graduated') bg-blue-600 text-white
                        @else bg-gray-500 text-white @endif">
                        {{ optional($student->academics)->enrollment_status ?? 'N/A' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Contact Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <p><strong>Email:</strong> {{ optional($student->contact)->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ optional($student->contact)->phone_number ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ optional($student->contact)->address ?? 'N/A' }}</p>
                <p><strong>Guardian Name:</strong> {{ optional($student->contact)->guardian_name ?? 'N/A' }}</p>
                <p><strong>Guardian Contact:</strong> {{ optional($student->contact)->guardian_contact ?? 'N/A' }}</p>
                <p><strong>Emergency Contact:</strong> {{ optional($student->contact)->emergency_contact ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Skills -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Skills</h2>
            @if($student->skills->isEmpty())
            <p class="text-gray-600">No skills recorded.</p>
            @else
            <ul class="list-disc pl-6 mt-2">
                @foreach($student->skills as $skill)
                <li>{{ $skill->skill_name }} ({{ $skill->proficiency_level }})</li>
                @endforeach
            </ul>
            @endif
        </div>

        <!-- Achievements -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Achievements</h2>
            @if($student->achievements->isEmpty())
            <p class="text-gray-600">No achievements recorded.</p>
            @else
            <ul class="list-disc pl-6 mt-2">
                @foreach($student->achievements as $achievement)
                <li>
                    <strong>{{ $achievement->achievement_name }}</strong> ({{ $achievement->category }}) -
                    {{ $achievement->award_date }} <br>
                    <span class="text-gray-600">Awarded by: {{ $achievement->awarding_body }}</span>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        <!-- Edit & Delete Buttons -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.students.edit', $student->student_id) }}"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                ✏️ Edit Student
            </a>

            <form action="{{ route('admin.students.destroy', $student->student_id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this student?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    🗑️ Delete Student
                </button>
            </form>
        </div>
    </div>
</x-app-layout>