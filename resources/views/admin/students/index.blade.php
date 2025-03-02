<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Header Row 1: Title & Search -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <h1 class="text-3xl font-bold text-white">Manage Students</h1>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.students.index') }}" class="flex items-center space-x-2 w-full md:w-auto">
                <x-text-input type="text" name="search" placeholder="Search students..."
                    value="{{ request('search') }}"
                    class="w-72 border border-gray-300 focus:ring-primary focus:border-primary rounded-lg px-4 py-2 text-gray-800 bg-white shadow-sm" />
                <x-primary-button class="bg-primary hover:bg-accent text-white px-4 py-2 rounded-lg shadow-md">
                    🔍 Search
                </x-primary-button>
            </form>
        </div>

        <!-- Header Row 2: Buttons -->
        <div class="flex flex-wrap gap-3 justify-start md:justify-between items-center mb-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.students.create') }}"
                    class="bg-secondary hover:bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg font-semibold shadow-md transition">
                    ➕ Add Student
                </a>

                <a href="{{ route('admin.students.template') }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md transition">
                    📥 Download Template
                </a>

                <a href="{{ route('admin.students.export') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition">
                    📤 Export Students
                </a>
            </div>

            <!-- Import Form -->
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data"
                class="flex items-center space-x-2 bg-white px-4 py-2 rounded-lg border border-gray-300 shadow-md">
                @csrf
                <input type="file" name="file"
                    class="text-sm text-gray-700 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border file:border-gray-300 file:text-gray-600 file:bg-gray-100 hover:file:bg-gray-200 transition">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    📥 Import
                </button>
            </form>
        </div>

        <!-- Student Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead class="bg-primary text-white text-lg">
                    <tr>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(0)">Student ID ⬍</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(1)">Name ⬍</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(2)">Program ⬍</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(3)">Year Level ⬍</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(4)">Status ⬍</th>
                        <th class="px-6 py-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-900">
                    @forelse($students as $student)
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">{{ $student->student_id }}</td>
                        <td class="px-6 py-4">
                            {{ $student->first_name }} {{ $student->middle_name ? $student->middle_name . ' ' : '' }} {{ $student->last_name }} {{ $student->suffix ?? '' }}
                        </td>
                        <td class="px-6 py-4">{{ optional($student->academics)->program ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ optional($student->academics)->year_level ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-sm font-medium rounded-lg
                                    @if(optional($student->academics)->enrollment_status === 'Enrolled') bg-green-500 text-white
                                    @elseif(optional($student->academics)->enrollment_status === 'Dropped') bg-red-500 text-white
                                    @elseif(optional($student->academics)->enrollment_status === 'Graduated') bg-blue-500 text-white
                                    @else bg-gray-500 text-white @endif">
                                {{ optional($student->academics)->enrollment_status ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-3">
                            <a href="{{ route('admin.students.show', $student->student_id) }}"
                                class="text-primary hover:underline font-semibold transition">
                                🔍 View
                            </a>
                            <a href="{{ route('admin.students.edit', $student->student_id) }}"
                                class="text-green-600 hover:underline font-semibold transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.students.destroy', $student->student_id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this student?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline font-semibold transition">
                                    ❌ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-600">
                            No students found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $students->links() }}
        </div>
    </div>

    <!-- JavaScript for Sortable Table -->
    <script>
        function sortTable(colIndex) {
            let table = document.querySelector("table tbody");
            let rows = Array.from(table.querySelectorAll("tr"));

            let sortedRows = rows.sort((a, b) => {
                let aText = a.cells[colIndex].innerText.trim();
                let bText = b.cells[colIndex].innerText.trim();
                return aText.localeCompare(bText, undefined, {
                    numeric: true
                });
            });

            table.innerHTML = "";
            sortedRows.forEach(row => table.appendChild(row));
        }
    </script>
</x-app-layout>