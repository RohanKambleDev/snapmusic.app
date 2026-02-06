<x-app-layout>
    <div class="flex overflow-hidden bg-gray-50">
        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 h-full overflow-y-auto p-6 lg:p-12 order-2 lg:order-1 scrollbar-hide justify-center flex items-center">
            <div class="w-full max-w-md mx-auto min-h-full flex flex-col relative">
                <div class="">
                    <h2 class="text-4xl font-bold text-gray-900 mb-10">Welcome back!</h2>
                    <p class="text-gray-500">Sign in to continue creating viral music videos in seconds.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com"
                                class="pl-10 block w-full border-gray-200 rounded-lg focus:ring-purple-500 focus:border-purple-500 bg-gray-50/50 py-3 text-gray-900 placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="........"
                                class="pl-10 block w-full border-gray-200 rounded-lg focus:ring-purple-500 focus:border-purple-500 bg-gray-50/50 py-3 text-gray-900 placeholder-gray-400">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 bg-gray-50" name="remember">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-purple-600 hover:text-purple-500" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-400 to-purple-600 hover:from-yellow-500 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform transition hover:scale-[1.01] gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Sign In
                    </button>

                    <div class="text-center text-sm text-gray-500">
                        Don't have an account? <a href="{{ route('register') }}" class="font-medium text-purple-600 hover:text-purple-500">Sign up for free</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side - Marketing -->
        <div class="hidden lg:flex lg:w-1/2 p-12 justify-center relative overflow-hidden order-1 lg:order-2 h-full">
            <div class="relative z-10 max-w-lg mx-auto w-full">

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Your creative studio awaits</h2>
            <p class="text-gray-500 mb-8">Join thousands of creators making viral music videos instantly.</p>

                <div class="space-y-4">
                    <!-- Feature 1 -->
                    <div class="rounded-2xl p-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg transform transition hover:scale-[1.02]">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1">Instant Creation</h3>
                                <p class="text-sm text-white/90 leading-relaxed">Upload a photo and song, get a viral video in seconds. No editing skills needed.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="rounded-2xl p-6 bg-gradient-to-r from-emerald-400 to-green-500 text-white shadow-lg transform transition hover:scale-[1.02]">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2-2v8a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1">Platform Ready</h3>
                                <p class="text-sm text-white/90 leading-relaxed">Perfect format for Instagram Reels, TikTok, YouTube Shorts, and WhatsApp Status.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="rounded-2xl p-6 bg-gradient-to-r from-yellow-400 to-orange-500 text-white shadow-lg transform transition hover:scale-[1.02]">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 3.214L13 21l-2.286-6.857L5 12l5.714-3.214L13 5z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1">Unlimited Exports</h3>
                                <p class="text-sm text-white/90 leading-relaxed">Create as many videos as you want. No watermarks, no restrictions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <!-- Visual Element -->
                <div class="mt-8 bg-gray-900 rounded-2xl p-6 shadow-2xl border border-gray-800">
                    <div class="flex items-center justify-between gap-4">
                        <div class="w-1/2 aspect-square bg-orange-200 rounded-xl relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-br from-orange-200 to-pink-200 opacity-80"></div>
                             <div class="absolute inset-0 flex items-center justify-center text-white/50">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <!-- Song label -->
                            <div class="absolute bottom-2 left-2 right-2 bg-white/90 backdrop-blur rounded-lg p-2 flex items-center gap-2">
                                <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                <div class="h-1.5 w-12 bg-gray-200 rounded-full"></div>
                                <span class="text-[10px] text-gray-500">Track.mp3</span>
                            </div>
                        </div>
                        
                        <div class="flex-shrink-0 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg z-10">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <div class="w-1/2 aspect-square bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl relative overflow-hidden flex items-center justify-center">
                            <div class="absolute inset-0 bg-white/10"></div>
                            <svg class="w-10 h-10 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 3.214L13 21l-2.286-6.857L5 12l5.714-3.214L13 5z"/></svg>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</x-app-layout>