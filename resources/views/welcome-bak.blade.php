<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
            <script src="{{ asset('js/app.js') }}" defer></script>
        @endif --}}
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        {{-- <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            
        </div> --}}

        <div class="relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full hero-blob -z-10 rounded-full translate-x-1/4 -translate-y-1/4"></div>

        <div class="container mx-auto px-6 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="space-y-6 max-w-lg">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-gray-900">
                    The fastest way to turn a photo & song into a video.
                </h1>
                <p class="text-lg text-gray-500 leading-relaxed">
                    No timeline. No complex editing. Just pick your media and export instantly for Reels, Status, and Shorts.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <button class="px-8 py-3 rounded-full text-white font-semibold btn-gradient shadow-lg flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bolt"></i> Create Video Now
                    </button>
                    <button class="px-8 py-3 rounded-full border border-gray-300 font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-download"></i> Download App
                    </button>
                </div>
            </div>

            <div class="relative w-full max-w-lg mx-auto lg:ml-auto">
                <div class="bg-gray-900 rounded-3xl p-4 shadow-2xl relative z-10">
                    <div class="flex gap-4">
                        <div class="bg-white rounded-xl p-3 flex-1 aspect-[4/5] flex flex-col items-center justify-center relative">
                            <div class="w-full h-full bg-orange-100 rounded-lg flex items-center justify-center mb-2">
                                <i class="fa-regular fa-image text-3xl text-white opacity-50"></i>
                            </div>
                            <div class="w-full bg-gray-100 rounded-md p-2 flex items-center gap-2">
                                <i class="fa-solid fa-music text-gray-400 text-xs"></i>
                                <span class="text-[10px] text-gray-500">Summer Vibes.mp3</span>
                            </div>
                        </div>

                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg z-20">
                            <i class="fa-solid fa-arrow-right text-gray-400 text-sm"></i>
                        </div>

                        <div class="bg-pink-400 rounded-xl p-3 flex-1 aspect-[4/5] flex flex-col items-center justify-center relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-t from-pink-600 to-transparent opacity-40"></div>
                            <i class="fa-solid fa-wand-magic-sparkles text-3xl text-white mb-2 animate-pulse"></i>
                            <span class="text-xs text-white font-medium">Playing...</span>
                            
                            <div class="absolute bottom-4 left-3 right-3 h-1 bg-white/30 rounded-full">
                                <div class="w-1/3 h-full bg-white rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>