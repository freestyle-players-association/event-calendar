<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                    </a>
                </div>
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Event Calendar') }}
                </x-nav-link>
            </div>
            <div class="hidden md:block">
                <x-secondary-button class="mr-6">
                    <a href="{{ route('events.create') }}">
                        {{ __('Create Event') }}
                    </a>
                </x-secondary-button>
                <x-primary-button>
                    <a href="{{ route('login') }}">
                        {{ __('Log in') }}
                    </a>
                </x-primary-button>
                <span class="mx-2">or</span>
                <x-primary-button>
                    <a href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </x-primary-button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                {{ __('Event Calendar') }}
            </x-responsive-nav-link>
        </div>

    </div>
</nav>
