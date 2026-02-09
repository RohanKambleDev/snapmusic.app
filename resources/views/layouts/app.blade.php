<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body class="font-sans antialiased {{ (request()->is('/') || request()->routeIs('how-it-works.*') || request()->routeIs('use-case.*')) ? 'bg-gray-950 text-white' : 'bg-gray-50 text-gray-900' }}" x-data="{ mobileMenuOpen: false }">
        <div class="min-h-screen flex flex-col">
            {{-- @include('layouts.navigation') --}}

            @include('layouts.header')

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>

        <!-- Page Scripts -->
        @stack('scripts')
    </body>
</html>
