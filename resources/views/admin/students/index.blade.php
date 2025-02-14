<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header & Search -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Manage Students</h1>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.students.index') }}" class="flex space-x-2">
                <input type="text" name="search" placeholder="Search students..."
                    value="{{ request('search') }}"
                    class="px-3 py-2 border rounded-lg focus:ring focus:ring-primary">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Search
                </button>
            </form>

            <a href="{{ route('admin.students.create') }}"
                class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                + Add Student
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                <table class="w-full border border-gray-300">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Program</th>
                            <th class="px-4 py-2">Year Level</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach($students as $student)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $student->student_id }}</td>
                            <td class="px-4 py-2">
                                {{ $student->first_name }} {{ $student->middle_name ? $student->middle_name . ' ' : '' }}
                                {{ $student->last_name }} {{ $student->suffix ?? '' }}
                            </td>
                            <td class="px-4 py-2">{{ optional($student->academics)->program ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ optional($student->academics)->year_level ?? 'N/A' }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 text-sm font-medium rounded-lg
                                    @if(optional($student->academics)->enrollment_status === 'Enrolled') bg-green-500 text-white
                                    @elseif(optional($student->academics)->enrollment_status === 'Dropped') bg-red-600 text-white
                                    @elseif(optional($student->academics)->enrollment_status === 'Graduated') bg-blue-600 text-white
                                    @else bg-gray-500 text-white @endif">
                                    {{ optional($student->academics)->enrollment_status ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('admin.students.show', $student->student_id) }}" class="text-blue-600 hover:text-blue-800">
                                    View
                                </a>
                                <a href="{{ route('admin.students.edit', $student->student_id) }}" class="text-green-600 hover:text-green-800">
                                    Edit
                                </a>
                                <form action="{{ route('admin.students.destroy', $student->student_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laravel Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>