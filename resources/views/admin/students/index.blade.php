<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header & Search -->
        <div class="flex flex-wrap justify-between items-center mb-6 space-y-4 sm:space-y-0">
            <h1 class="text-3xl font-bold text-white">Manage Students</h1> <!-- White Removed for Better Visibility -->

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.students.index') }}" class="flex space-x-2">
                <x-text-input type="text" name="search" placeholder="Search students..."
                    value="{{ request('search') }}" class="w-64 border-primary bg-white text-gray-900" />
                <x-primary-button class="bg-primary hover:bg-accent text-white">Search</x-primary-button>
            </form>

            <a href="{{ route('admin.students.create') }}" class="bg-secondary hover:bg-yellow-500 text-gray-900 px-4 py-2 rounded-md font-semibold">
                + Add Student
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                <table class="w-full border border-gray-300">
                    <thead class="bg-primary text-white text-lg">
                        <tr>
                            <th class="px-4 py-3">Student ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Program</th>
                            <th class="px-4 py-3">Year Level</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        @foreach($students as $student)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-3">{{ $student->student_id }}</td>
                            <td class="px-4 py-3">
                                {{ $student->first_name }} {{ $student->middle_name ? $student->middle_name . ' ' : '' }}
                                {{ $student->last_name }} {{ $student->suffix ?? '' }}
                            </td>
                            <td class="px-4 py-3">{{ optional($student->academics)->program ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ optional($student->academics)->year_level ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-sm font-medium rounded-lg
                                    @if(optional($student->academics)->enrollment_status === 'Enrolled') bg-green-600 text-white
                                    @elseif(optional($student->academics)->enrollment_status === 'Dropped') bg-red-600 text-white
                                    @elseif(optional($student->academics)->enrollment_status === 'Graduated') bg-blue-600 text-white
                                    @else bg-gray-500 text-white @endif">
                                    {{ optional($student->academics)->enrollment_status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 flex space-x-3">
                                <a href="{{ route('admin.students.show', $student->student_id) }}"
                                    class="text-primary hover:underline font-semibold">
                                    View
                                </a>
                                <a href="{{ route('admin.students.edit', $student->student_id) }}"
                                    class="text-green-600 hover:underline font-semibold">
                                    Edit
                                </a>
                                <form action="{{ route('admin.students.destroy', $student->student_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laravel Pagination -->
        <div class="mt-6">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>