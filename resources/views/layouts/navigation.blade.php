<header class="bg-white border-b border-slate-200 fixed w-full z-10">
    <div class="max-w-6xl mx-auto flex h-16">
        <!-- Logo -->
        <div class="m-2 self-center">
            <div class="bg-indigo-600 rounded-sm aspect-square p-2">
                <a href="{{route('home')}}">
                    <img src="{{ asset('images/fpa-logo-white.png') }}"
                         alt="FPA Logo"
                         class="object-cover h-10 w-10"
                    />
                </a>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="grow flex gap-4 justify-between items-center pl-4">
            <div class="grow flex gap-4 h-full">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Event Calendar') }}
                </x-nav-link>
                @if(Auth::user())
                    <x-nav-link class="hidden md:flex" :href="route('dashboard')"
                                :active="request()->routeIs('dashboard')">
                        {{ __('My Events') }}
                    </x-nav-link>
                @endif
            </div>

            <x-link href="{{ route('events.create') }}" class="hidden md:flex h-8">
                {{ __('Add Event') }}
            </x-link>
            @if(!Auth::user())
                <x-link href="{{ route('login') }}" class="hidden md:flex h-8">
                    {{ __('Login') }}
                </x-link>
            @endif
            <div class="relative flex items-center" x-data="{ open: false }" @click.away="open = false">
                <!-- Hamburger Button -->
                <button @click="open = ! open"
                        class="inline-flex p-2 mr-4 sm:mr-0 rounded-md text-slate-800
                               hover:bg-gray-100
                               z-10
                               transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Burger Icon -->
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <!-- X Icon -->
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Navigation Menu Dropdown -->
                <div :class="{'block': open, 'hidden': ! open}"
                     class="bg-white border rounded-md w-64 absolute right-0 top-0 pt-12"
                    x-transition>
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('events.index')"
                                               :active="request()->routeIs('home')">
                            {{ __('Event Calendar') }}
                        </x-responsive-nav-link>
                        @if(Auth::user())
                            <x-responsive-nav-link :href="route('dashboard')"
                                                   :active="request()->routeIs('dashboard')">
                                {{ __('My Events') }}
                            </x-responsive-nav-link>
                        @endif
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="mt-3 space-y-1">
                            @if(Auth::user())
                                <x-responsive-nav-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                                           onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            @else
                                <x-responsive-nav-link :href="route('login')">
                                    {{ __('Log in') }}
                                </x-responsive-nav-link>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </div>
</header>
