<!-- ================= HEADER ================= -->
@php
    $isDark = true; // Global dark/transparent header
    $navBaseClass = 'transition-all duration-300 hover:scale-105';
    $navTextClass = "$navBaseClass text-gray-400 hover:text-white";
    $activeClass = 'text-white font-semibold !opacity-100 after:content-[\'\'] after:block after:h-0.5 after:w-full after:bg-purple-500 after:mt-1';
    $logoClass = 'fill-white text-white';
    $logoTextClass = 'text-white';
@endphp

<header x-data="{ mobileMenuOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 'bg-gray-900/80 backdrop-blur-md border-b border-white/10 shadow-lg': scrolled, 'bg-transparent': !scrolled }"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300 px-6 py-4">
  
  <div class="max-w-7xl mx-auto flex items-center justify-between">
    <!-- Logo -->
    <a href="/" class="flex items-center gap-2 font-bold text-xl tracking-tight transition hover:opacity-80">
        <x-application-logo class="w-8 h-8 {{ $logoClass }}" />
        <span class="{{ $logoTextClass }}">SnapMusic</span>
    </a>

    <!-- Desktop Nav -->
    <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
        <x-nav-link :href="route('use-case.index')" :active="request()->routeIs('use-case.*')" 
            class="{{ $navTextClass }} {{ request()->routeIs('use-case.*') ? $activeClass : '' }}">
            {{ __('Use Cases') }}
        </x-nav-link>
        <x-nav-link :href="route('how-it-works.index')" :active="request()->routeIs('how-it-works.*')" 
            class="{{ $navTextClass }} {{ request()->routeIs('how-it-works.*') ? $activeClass : '' }}">
            {{ __('How it Works') }}
        </x-nav-link>
        
        @guest
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" 
                class="{{ $navTextClass }} {{ request()->routeIs('login') ? $activeClass : '' }}">
                {{ __('Sign In') }}
            </x-nav-link>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" 
                class="{{ $navTextClass }} {{ request()->routeIs('register') ? $activeClass : '' }}">
                {{ __('Sign Up') }}
            </x-nav-link>
        @endguest

        @auth
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="{{ $navTextClass }} {{ request()->routeIs('dashboard') ? $activeClass : '' }}">
                {{ __('Dashboard') }}
            </x-nav-link>
        @endauth

        <a href="{{ route('make-a-video.index') }}" class="px-5 py-2.5 rounded-full bg-white text-gray-900 font-semibold text-sm transition-all hover:bg-gray-100 hover:shadow-lg hover:-translate-y-0.5 border border-gray-200">
            Create Video
        </a>

        <!-- Settings Dropdown -->
        @auth
        <div class="hidden sm:flex sm:items-center ml-4 relative" x-data="{ open: false }">
            <button @click="open = !open" class="inline-flex items-center gap-2 text-sm font-medium {{ $navTextClass }} focus:outline-none transition">
                <div>{{ Auth::user()->name }}</div>
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 top-full mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50"
                 style="display: none;">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
        @endauth
    </nav>

    <!-- Mobile Menu Button -->
    <div class="md:hidden flex items-center">
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="{{ $navTextClass }} focus:outline-none p-2">
            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
  </div>

  <!-- Mobile Nav Overlay -->
  <div 
    x-show="mobileMenuOpen" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    @click.away="mobileMenuOpen = false"
    x-cloak
    class="absolute top-full left-0 right-0 mx-4 mt-2 p-4 bg-white/95 backdrop-blur-xl shadow-2xl rounded-2xl border border-gray-100 md:hidden flex flex-col gap-2 text-gray-800 z-50 ring-1 ring-black/5">
        
        <x-nav-link :href="route('use-case.index')" :active="request()->routeIs('use-case.*')" 
            class="block px-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('use-case.*') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
            {{ __('Use Cases') }}
        </x-nav-link>
        <x-nav-link :href="route('how-it-works.index')" :active="request()->routeIs('how-it-works.*')" 
            class="block px-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('how-it-works.*') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
            {{ __('How it Works') }}
        </x-nav-link>
        
        @guest
            <div class="border-t border-gray-100 my-2"></div>
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" 
                class="block px-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('login') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                {{ __('Sign In') }}
            </x-nav-link>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" 
                class="block px-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('register') ? 'bg-purple-50 text-purple-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                {{ __('Sign Up') }}
            </x-nav-link>
        @endguest

        <div class="mt-2">
            <a href="{{ route('make-a-video.index') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-gray-900 text-white font-semibold shadow-md">
                Create Video
            </a>
        </div>
  </div>
</header>