<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-ink-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center font-extrabold text-sm tracking-tighter shadow-sm shadow-brand-600/30">PO</span>
                        <span class="text-base font-extrabold tracking-tighter text-ink-900">PENGOFFSEC</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @auth
                        @if(auth()->user()->is_admin)
                            <x-nav-link href="{{ url('/admin/dashboard') }}" :active="request()->is('admin/*')">
                                {{ __('Admin') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-ink-200 text-sm leading-4 font-medium rounded-full text-ink-700 bg-white hover:bg-ink-50 hover:border-ink-300 focus:outline-none transition ease-in-out duration-150">
                            <span class="w-6 h-6 rounded-full bg-brand-50 text-brand-700 text-xs font-bold flex items-center justify-center">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="hidden md:inline max-w-[120px] truncate">{{ Auth::user()->name }}</span>

                            <svg class="h-4 w-4 text-ink-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-ink-100">
                            <div class="text-sm font-medium text-ink-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-ink-600 truncate">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-ink-600 hover:bg-ink-100 transition duration-150 ease-in-out" aria-label="Toggle navigation menu">
                    <svg x-show="!open" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg x-cloak x-show="open" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-ink-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @auth
                @if(auth()->user()->is_admin)
                    <x-responsive-nav-link href="{{ url('/admin/dashboard') }}" :active="request()->is('admin/*')">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-ink-200">
            <div class="px-4">
                <div class="font-medium text-base text-ink-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-ink-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
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
            </div>
        </div>
    </div>
</nav>
