<x-app-layout>
    <div class="container mx-auto px-6 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-3">
            <h1 class="text-3xl font-bold text-white">Edit Student</h1>
            <a href="{{ route('admin.students.index') }}" class="text-secondary text-base hover:underline">
                ← Back to Students
            </a>
        </div>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('admin.students.update', $student->student_id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="bg-card shadow-lg rounded-xl p-6">
                <h2 class="text-xl font-semibold text-primary border-b pb-2 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    @foreach ([
                    'first_name' => 'First Name',
                    'middle_name' => 'Middle Name',
                    'last_name' => 'Last Name',
                    'suffix' => 'Suffix (Optional)'
                    ] as $field => $label)
                    <div>
                        <x-input-label for="{{ $field }}" value="{{ $label }}" />
                        <x-text-input id="{{ $field }}" type="text" name="{{ $field }}"
                            value="{{ old($field, $student->$field) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm"
                            placeholder="{{ $field == 'suffix' ? 'e.g., Jr., III' : '' }}" />
                    </div>
                    @endforeach

                    <div>
                        <x-input-label for="birth_date" value="Birth Date" />
                        <x-text-input id="birth_date" required type="date" name="birth_date"
                            value="{{ old('birth_date', $student->birth_date) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                    </div>

                    <!-- Gender -->
                    <div>
                        <x-input-label for="gender" value="Gender" />
                        <select id="gender" name="gender"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2">
                            @foreach(['Male', 'Female', 'Other'] as $option)
                            <option value="{{ $option }}" {{ old('gender', $student->gender) == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @foreach (['nationality' => 'Nationality', 'religion' => 'Religion'] as $field => $label)
                    <div>
                        <x-input-label for="{{ $field }}" value="{{ $label }}" />
                        <x-text-input id="{{ $field }}" required type="text" name="{{ $field }}"
                            value="{{ old($field, $student->$field) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                    </div>
                    @endforeach

                    <!-- Blood Type -->
                    <div>
                        <x-input-label for="blood_type" value="Blood Type" />
                        <select id="blood_type" name="blood_type"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2">
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type', $student->blood_type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Student Type -->
                    <div>
                        <x-input-label for="student_type" value="Student Type" />
                        <select id="student_type" name="student_type"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2">
                            @foreach(['Regular', 'Irregular', 'Transferee', 'Foreign'] as $type)
                            <option value="{{ $type }}" {{ old('student_type', $student->student_type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <!-- Academic Details -->
            <div class="bg-card shadow-lg rounded-xl p-6">
                <h2 class="text-xl font-semibold text-primary border-b pb-2 mb-4">Academic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <x-input-label for="student_number" value="Student Number" />
                        <x-text-input id="student_number" required type="text" name="student_number"
                            value="{{ old('student_number', optional($student->academics)->student_number) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('student_number')" />
                    </div>

                    <!-- Enrollment Status -->
                    <div>
                        <x-input-label for="enrollment_status" value="Enrollment Status" />
                        <select id="enrollment_status" name="enrollment_status"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm p-2">
                            @foreach(['Enrolled', 'Dropped', 'Graduated'] as $status)
                            <option value="{{ $status }}" {{ old('enrollment_status', optional($student->academics)->enrollment_status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="year_level" value="Year Level" />
                        <x-text-input id="year_level" required type="number" name="year_level"
                            value="{{ old('year_level', optional($student->academics)->year_level) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('year_level')" />
                    </div>

                    <div>
                        <x-input-label for="college" value="College" />
                        <x-text-input id="college" required type="text" name="college"
                            value="{{ old('college', optional($student->academics)->college) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('college')" />
                    </div>

                    <div>
                        <x-input-label for="program" value="Program" />
                        <x-text-input id="program" required type="text" name="program"
                            value="{{ old('program', optional($student->academics)->program) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('program')" />
                    </div>

                    <div>
                        <x-input-label for="section" value="Section" />
                        <x-text-input id="section" required type="text" name="section"
                            value="{{ old('section', optional($student->academics)->section) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('section')" />
                    </div>

                    <div>
                        <x-input-label for="gwa" value="GWA (Grade Point Average)" />
                        <x-text-input id="gwa" required type="text" name="gwa"
                            value="{{ old('gwa', optional($student->academics)->gwa) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('gwa')" />
                    </div>

                </div>
            </div>


            <!-- Contact Information -->
            <div class="bg-card shadow-lg rounded-xl p-6">
                <h2 class="text-xl font-semibold text-primary border-b pb-2 mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-800">

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" required type="email" name="email"
                            value="{{ old('email', optional($student->contact)->email) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone_number" value="Phone Number" />
                        <x-text-input id="phone_number" required type="text" name="phone_number"
                            value="{{ old('phone_number', optional($student->contact)->phone_number) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('phone_number')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="address" value="Address" />
                        <x-text-input id="address" required type="text" name="address"
                            value="{{ old('address', optional($student->contact)->address) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <div>
                        <x-input-label for="guardian_name" value="Guardian Name" />
                        <x-text-input id="guardian_name" required type="text" name="guardian_name"
                            value="{{ old('guardian_name', optional($student->contact)->guardian_name) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('guardian_name')" />
                    </div>

                    <div>
                        <x-input-label for="guardian_contact" value="Guardian Contact" />
                        <x-text-input id="guardian_contact" required type="text" name="guardian_contact"
                            value="{{ old('guardian_contact', optional($student->contact)->guardian_contact) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('guardian_contact')" />
                    </div>

                    <div>
                        <x-input-label for="emergency_contact" value="Emergency Contact" />
                        <x-text-input id="emergency_contact" required type="text" name="emergency_contact"
                            value="{{ old('emergency_contact', optional($student->contact)->emergency_contact) }}"
                            class="w-full border-gray-300 bg-white text-gray-900 rounded-lg shadow-sm" />
                        <x-input-error :messages="$errors->get('emergency_contact')" />
                    </div>

                </div>
            </div>

            <!-- Skills & Talents Section -->
            <div class="bg-card shadow-lg rounded-xl p-6">
                <!-- Skills & Talents Section -->
                <h2 class="text-xl font-semibold text-primary pb-2 mb-4">Skills & Talents</h2>

                <div id="skillsContainer">
                    @foreach($student->skills as $skill)
                    <hr class="border-t border-gray-300 my-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 skill-entry">
                        <div>
                            <x-input-label value="Skill Name" />
                            <x-text-input required type="text" name="skills[{{ $loop->index }}][skill_name]"
                                value="{{ old('skills.'.$loop->index.'.skill_name', $skill->skill_name) }}"
                                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('skills.'.$loop->index.'.skill_name')" />
                        </div>

                        <div class="flex space-x-2">
                            <div class="w-full">
                                <x-input-label value="Proficiency Level" />
                                <select name="skills[{{ $loop->index }}][proficiency_level]"
                                    class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm">
                                    @foreach(['Beginner', 'Intermediate', 'Advanced', 'Expert'] as $level)
                                    <option value="{{ $level }}"
                                        {{ old('skills.'.$loop->index.'.proficiency_level', $skill->proficiency_level) == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Remove Skill Button -->
                            <button required type="button"
                                class="self-end bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition remove-skill">
                                -
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Add Skill Button -->
                <button required type="button" id="addSkill"
                    class="mt-4 bg-primary text-white px-4 py-2 rounded-md hover:bg-accent transition ease-in-out duration-150">
                    + Add Skill
                </button>

            </div>
            <!-- Achievements Section -->
            <div class="bg-card shadow-lg rounded-xl p-6">

                <h2 class="text-xl font-semibold text-primary pb-2 mb-4">Achievements</h2>

                <div id="achievementsContainer">
                    @foreach($student->achievements as $achievement)
                    <hr class="border-t border-gray-300 my-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 achievement-entry">
                        <div>
                            <x-input-label value="Achievement Name" />
                            <x-text-input required type="text" name="achievements[{{ $loop->index }}][achievement_name]" required
                                value="{{ old('achievements.'.$loop->index.'.achievement_name', $achievement->achievement_name) }}"
                                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('achievements.'.$loop->index.'.achievement_name')" />
                        </div>

                        <div>
                            <x-input-label value="Category" />
                            <select name="achievements[{{ $loop->index }}][category]" required
                                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm">
                                @foreach(['Academic', 'Sports', 'Arts', 'Technology', 'Community'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('achievements.'.$loop->index.'.category', $achievement->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('achievements.'.$loop->index.'.category')" />
                        </div>

                        <div>
                            <x-input-label value="Award Date" />
                            <x-text-input required type="date" name="achievements[{{ $loop->index }}][award_date]"
                                value="{{ old('achievements.'.$loop->index.'.award_date', $achievement->award_date) }}"
                                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('achievements.'.$loop->index.'.award_date')" />
                        </div>

                        <div>
                            <x-input-label value="Awarding Body" />
                            <x-text-input required type="text" name="achievements[{{ $loop->index }}][awarding_body]"
                                value="{{ old('achievements.'.$loop->index.'.awarding_body', $achievement->awarding_body) }}"
                                class="w-full border border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white p-2 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('achievements.'.$loop->index.'.awarding_body')" />
                        </div>

                        <!-- Remove Achievement Button -->
                        <div class="flex items-end">
                            <button required type="button"
                                class="self-end bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition remove-achievement">
                                -
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Add Achievement Button -->
                <button required type="button" id="addAchievement"
                    class="mt-4 bg-primary text-white px-4 py-2 rounded-md hover:bg-accent transition ease-in-out duration-150">
                    + Add Achievement
                </button>

                <!-- Submit & Cancel -->
                <div class="flex justify-end space-x-4 mt-8">
                    <x-secondary-button onclick="window.history.back();">Cancel</x-secondary-button>
                    <x-primary-button required type="submit">Save Changes</x-primary-button>
                </div>
            </div>
        </form>
    </div>

    <!-- Import JavaScript for dynamic form handling -->
    @vite(['resources/js/edit-student.js'])
</x-app-layout>