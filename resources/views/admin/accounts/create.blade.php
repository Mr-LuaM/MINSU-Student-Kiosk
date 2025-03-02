<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6 border-b border-gray-300 pb-4">
            <h1 class="text-3xl font-bold text-white">Add New Admin Account</h1>
            <a href="{{ route('admin.accounts.index') }}" class="text-secondary text-md hover:underline">
                ← Back to Accounts
            </a>
        </div>

        <!-- Info Message -->
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-900 p-4 mb-6 rounded-md">
            <p class="text-lg font-semibold">⚠️ Important Notice:</p>
            <ul class="list-disc pl-5 mt-2 text-gray-800 text-base">
                <li>All newly created accounts are **Admin** by default.</li>
                <li>Email verification is automatic since this is an admin-created account.</li>
                <li>Make sure to **share the email and password** with the new admin.</li>
                <li>If something goes wrong, **delete the account immediately**.</li>
            </ul>
        </div>

        <!-- Create Admin Account Form -->
        <div class="bg-card shadow-lg rounded-xl p-8">
            <h2 class="text-3xl font-semibold text-primary border-b pb-3 mb-5">Admin Account Information</h2>

            <form method="POST" action="{{ route('admin.accounts.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input id="name" type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white  rounded-md shadow-sm" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" value="Email Address" />
                        <x-text-input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white  rounded-md shadow-sm" />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Password" />
                        <div class="relative">
                            <x-text-input id="password" type="password" name="password" required
                                class="w-full border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white  rounded-md shadow-sm pr-10" />
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                👁️
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <div class="relative">
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full border-gray-300 focus:border-primary focus:ring-primary text-gray-900 bg-white  rounded-md shadow-sm pr-10" />
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                👁️
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>

                <!-- Submit & Cancel -->
                <div class="flex justify-end space-x-4 mt-8">
                    <x-secondary-button onclick="window.history.back();">Cancel</x-secondary-button>
                    <x-primary-button type="submit">Create Admin Account</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Password Toggle -->
    <script>
        function togglePassword(id) {
            let input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</x-app-layout>