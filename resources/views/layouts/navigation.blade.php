<nav x-data="{ open: false }" class="bg-primary text-white border-b border-secondary shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <!-- Logo & Title -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <x-application-logo class="h-10 w-auto fill-current text-white" />
                    <span class="text-[1.5rem] font-bold tracking-wide">MinSU Student Kiosk</span>
                </a>
            </div>

            <!-- Navigation Links (Centered) -->
            <div class="hidden md:flex flex-1 justify-center space-x-8">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white relative text-[1.2rem] ">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.index')" class="text-white relative text-[1.2rem] ">
                    {{ __('Manage Students') }}
                </x-nav-link>

                <x-nav-link :href="route('admin.accounts.index')" :active="request()->routeIs('admin.accounts.index')" class="text-white relative text-[1.2rem] ">
                    {{ __('Manage Accounts') }}
                </x-nav-link>
            </div>

            <!-- User Dropdown (Right) -->
            <div class="hidden md:flex items-center relative ">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-5 py-3 text-white font-medium bg-primary rounded-md focus:outline-none text-[1.2rem]">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-2 h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="hover:bg-red-500 hover:text-white"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button (Visible Only at 1100px or Below) -->
            <div class="md:hidden flex items-center">
                <button @click="open = ! open" class="p-3 rounded-md text-white focus:outline-none">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Responsive Navigation Menu (Only for 1100px or Below) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-primary text-white">
        <div class="pt-3 pb-4 space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[1.2rem] ">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.index')" class="text-[1.2rem] ">
                {{ __('Manage Students') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.accounts.index')" :active="request()->routeIs('admin.accounts.index')" class="text-[1.2rem] ">
                {{ __('Manage Accounts') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User Options -->
        <div class="pt-4 pb-2 border-t border-secondary">
            <div class="px-4">
                <div class="font-medium text-lg text-white">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-[1.2rem] ">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-[1.2rem] hover:bg-red-500 hover:text-white"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>