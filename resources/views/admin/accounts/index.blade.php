<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <h1 class="text-3xl font-bold text-white">Manage Admin Accounts</h1>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.accounts.index') }}" class="flex items-center space-x-2 w-full md:w-auto">
                <x-text-input type="text" name="search" placeholder="Search accounts..."
                    value="{{ request('search') }}"
                    class="w-72 border border-gray-300 focus:ring-primary focus:border-primary rounded-lg px-4 py-2 text-gray-800 bg-white shadow-sm" />
                <x-primary-button class="bg-primary hover:bg-accent text-white px-4 py-2 rounded-lg shadow-md">
                    🔍 Search
                </x-primary-button>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 justify-start md:justify-between items-center mb-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.accounts.create') }}"
                    class="bg-secondary hover:bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg font-semibold shadow-md transition">
                    ➕ Add Admin
                </a>
            </div>
        </div>

        <!-- Accounts Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead class="bg-primary text-white text-lg">
                    <tr>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(0)">ID ⬍</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(1)">Name ⬍</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(2)">Email ⬍</th>
                        <th class="px-6 py-4 text-left">Verified</th>
                        <th class="px-6 py-4 text-left cursor-pointer" onclick="sortTable(3)">Created At ⬍</th>
                        <th class="px-6 py-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-900">
                    @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="px-6 py-4 font-semibold">{{ $user->id }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->email_verified_at)
                            <span class="px-3 py-1 text-sm font-medium rounded-lg bg-green-500 text-white">Verified</span>
                            @else
                            <span class="px-3 py-1 text-sm font-medium rounded-lg bg-red-500 text-white">Not Verified</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4">
                            @if(Auth::id() !== $user->id) <!-- Prevent deleting self -->
                            <form action="{{ route('admin.accounts.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this admin account? This action cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline font-semibold transition">
                                    ❌ Delete
                                </button>
                            </form>
                            @else
                            <span class="text-gray-500 italic">Cannot delete yourself</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-600">
                            No admin accounts found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $users->links() }}
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