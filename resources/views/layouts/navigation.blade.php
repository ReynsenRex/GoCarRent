<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg border-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <!-- Custom GoCarRent Logo -->
                        <div class="bg-white p-2 rounded-lg shadow-md">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                            </svg>
                        </div>
                        <div class="text-white">
                            <h1 class="text-xl font-bold">GoCarRent</h1>
                            <p class="text-xs text-blue-100">Premium Car Rental</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->isCustomer())
                        <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('customer.cars.index')" :active="request()->routeIs('customer.cars.*')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-car mr-2"></i>{{ __('Browse Cars') }}
                        </x-nav-link>
                        <x-nav-link :href="route('customer.bookings.index')" :active="request()->routeIs('customer.bookings.*')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-calendar-check mr-2"></i>{{ __('My Bookings') }}
                        </x-nav-link>
                    @elseif(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-car mr-2"></i>{{ __('Manage Cars') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-clipboard-list mr-2"></i>{{ __('Bookings') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.statistics')" :active="request()->routeIs('admin.statistics')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-chart-bar mr-2"></i>{{ __('Statistics') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-200 border-white hover:border-blue-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notification Bell (for future use) -->
                <button class="relative p-2 text-white hover:text-blue-200 focus:outline-none focus:text-blue-200 transition duration-150 ease-in-out mr-4">
                    <i class="fas fa-bell text-lg"></i>
                    <!-- Notification badge -->
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-600 transform translate-x-1/2 -translate-y-1/2 bg-white rounded-full">3</span>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border-2 border-white/20 text-sm leading-4 font-medium rounded-lg text-white bg-white/10 hover:bg-white/20 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-blue-200">{{ Auth::user()->role->name ?? 'User' }}</div>
                                </div>
                            </div>

                            <div class="ms-3">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            <div class="text-xs text-blue-600 font-medium">{{ Auth::user()->role->name ?? 'User' }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                            <i class="fas fa-user-edit mr-2 text-gray-400"></i>
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        @if(auth()->user()->isCustomer())
                            <x-dropdown-link :href="route('customer.bookings.index')" class="flex items-center">
                                <i class="fas fa-history mr-2 text-gray-400"></i>
                                {{ __('Booking History') }}
                            </x-dropdown-link>
                        @endif

                        <div class="border-t border-gray-200"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 hover:bg-white/10 focus:outline-none focus:bg-white/10 focus:text-blue-200 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-800">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isCustomer())
                <x-responsive-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customer.cars.index')" :active="request()->routeIs('customer.cars.*')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-car mr-2"></i>{{ __('Browse Cars') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customer.bookings.index')" :active="request()->routeIs('customer.bookings.*')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-calendar-check mr-2"></i>{{ __('My Bookings') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-car mr-2"></i>{{ __('Manage Cars') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-clipboard-list mr-2"></i>{{ __('Bookings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.statistics')" :active="request()->routeIs('admin.statistics')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-chart-bar mr-2"></i>{{ __('Statistics') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-blue-500">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-200">{{ Auth::user()->email }}</div>
                <div class="text-xs text-blue-100 font-medium">{{ Auth::user()->role->name ?? 'User' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-blue-200 hover:bg-blue-700 border-blue-300">
                    <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-200 hover:text-red-100 hover:bg-red-600 border-red-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
