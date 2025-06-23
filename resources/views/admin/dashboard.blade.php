<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Dashboard Title -->
        <h1 class="text-4xl font-bold text-white mb-6">Admin Dashboard</h1>

        <!-- Grid Layout for Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Admins -->
            <div class="bg-card shadow-lg rounded-lg p-6 text-center flex flex-col items-center">
                <svg class="w-12 h-12 text-primary mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 14a4 4 0 10-8 0m8 0a4 4 0 00-8 0m8 0V12a4 4 0 00-8 0v2m-4 6a8 8 0 0116 0z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-700">Total Admins</h2>
                <p class="text-4xl font-bold text-primary">{{ $totalAdmins }}</p>
            </div>

            <!-- Total Students -->
            <div class="bg-card shadow-lg rounded-lg p-6 text-center flex flex-col items-center">
                <svg class="w-12 h-12 text-green-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 7v-6m0 6a9 9 0 01-9-9V9m18 0a9 9 0 01-9 9m0-9V3" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-700">Total Students</h2>
                <p class="text-4xl font-bold text-primary">{{ $totalStudents }}</p>
            </div>

            <!-- Recently Added Admins -->
            <div class="bg-card shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">Recently Added Admins</h2>
                <ul class="mt-3 space-y-2">
                    @foreach($recentAdmins as $admin)
                    <li class="text-gray-800">{{ $admin->name }} ({{ $admin->email }})</li>
                    @endforeach
                </ul>
            </div>

            <!-- Recently Added Students -->
            <div class="bg-card shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">Recently Added Students</h2>
                <ul class="mt-3 space-y-2">
                    @foreach($recentStudents as $student)
                    <li class="text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Student Enrollment Trend Chart -->
            <div class="bg-card shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Student Enrollment Trends</h2>
                <canvas id="studentChart" style="max-height: 300px;"></canvas>

            </div>

            <!-- Admin Account Growth Chart -->
            <div class="bg-card shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Admin Account Growth</h2>
                <canvas id="accountChart" style="max-height: 300px;"></canvas>

            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-4 justify-start mb-6">
            <a href="{{ route('admin.accounts.create') }}" class="bg-secondary text-gray-900 px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-yellow-500 transition">
                ➕ Add Admin
            </a>
            <a href="{{ route('admin.students.create') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-green-600 transition">
                ➕ Add Student
            </a>
            <a href="{{ route('admin.students.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-blue-600 transition">
                📋 Manage Students
            </a>
            <a href="{{ route('admin.accounts.index') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-md font-semibold hover:bg-red-600 transition">
                👤 Manage Admins
            </a>
        </div>
    </div>

    <!-- Load Charts with Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Chart === "undefined") {
                console.error("Chart.js is NOT loaded.");
                return;
            }

            // Load formatted data from Laravel
            let studentEnrollmentDates = @json($studentEnrollmentDates); // ["Jan 2025", "Feb 2025"]
            let studentEnrollmentCounts = @json($studentEnrollmentCounts); // [5, 3, 2]
            let adminGrowthDates = @json($adminGrowthDates); // ["Jan 2025", "Feb 2025"]
            let adminGrowthCounts = @json($adminGrowthCounts); // [2, 1, 3]

            // console.log("Fixed Student Enrollment Dates:", studentEnrollmentDates);
            // console.log("Fixed Student Enrollment Counts:", studentEnrollmentCounts);
            // console.log("Fixed Admin Growth Dates:", adminGrowthDates);
            // console.log("Fixed Admin Growth Counts:", adminGrowthCounts);

            // Student Enrollment Trend Chart
            var ctx1 = document.getElementById('studentChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: studentEnrollmentDates,
                    datasets: [{
                        label: 'New Students',
                        data: studentEnrollmentCounts,
                        backgroundColor: 'rgba(0, 124, 61, 0.2)',
                        borderColor: '#007C3D',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 6,
                            }
                        },
                        y: {
                            ticks: {
                                stepSize: 1,
                            }
                        }
                    }
                }
            });

            // Admin Account Growth Chart
            var ctx2 = document.getElementById('accountChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: adminGrowthDates,
                    datasets: [{
                        label: 'New Admins',
                        data: adminGrowthCounts,
                        backgroundColor: 'rgba(0, 124, 221, 0.2)',
                        borderColor: '#007C3D',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 2,
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 6,
                            }
                        },
                        y: {
                            ticks: {
                                stepSize: 1,
                            }
                        }
                    }
                }
            });
        });
    </script>



</x-app-layout>