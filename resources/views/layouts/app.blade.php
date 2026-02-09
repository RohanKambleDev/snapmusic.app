<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body class="font-sans antialiased bg-gray-950 text-white" x-data="{ mobileMenuOpen: false }">
        <div class="min-h-screen flex flex-col">
            {{-- @include('layouts.navigation') --}}

            @include('layouts.header')

            <!-- Page Content -->
            <main class="flex-grow pt-24">
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>

        <!-- Page Scripts -->
        @stack('scripts')
    </body>
</html>
