<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    {{-- <body class="font-sans antialiased"> --}}
    <body class="bg-white text-gray-900" x-data="{ mobileMenuOpen: false }">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @include('layouts.header')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>

        <!-- Page Scripts -->
        @stack('scripts')
    </body>
</html>
