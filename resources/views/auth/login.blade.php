<x-app-layout>
    <div class="flex overflow-hidden bg-gray-50 h-screen">
        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 h-full overflow-y-auto p-6 lg:p-12 order-2 lg:order-1 scrollbar-hide justify-center flex items-center">
            <div class="w-full max-w-md mx-auto min-h-full flex flex-col relative">
                <div class="">
                    <h2 class="text-4xl font-bold text-gray-900 mb-10">Welcome back!</h2>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Your creative studio awaits</h2>
                    <p class="text-gray-500 mb-8">Join thousands of creators making viral music videos instantly.</p>
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
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com"
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

                <div class="mt-8 pb-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="#" class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors items-center gap-2">
                            <svg class="h-5 w-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            Google
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors items-center gap-2">
                             <svg class="h-5 w-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                            GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Marketing -->
        <div class="hidden lg:flex lg:w-1/2 bg-gray-50 p-12 mt-5 justify-center relative overflow-hidden order-1 lg:order-2 h-full">
            <div class="relative z-10 max-w-lg mx-auto w-full">

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

                <!-- Visual Element -->
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
                </div>

            </div>
        </div>
    </div>
</x-app-layout>