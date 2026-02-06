<x-app-layout>
    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-32 items-start px-12 py-12">

        <section class="max-w-6xl mx-auto">
    
    <!-- Badge -->
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 text-sm font-medium mb-6">
      ✨ Join the creator revolution
    </div>

    <!-- Heading -->
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4">
      Start creating viral videos in seconds
    </h1>

    <p class="text-gray-600 max-w-2xl text-lg">
      Join thousands of creators who are already making stunning music videos with zero effort.
    </p>

    <!-- Stats -->
    {{-- <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center mb-14">
      <div>
        <div class="text-4xl font-bold text-green-500">2M+</div>
        <div class="text-gray-600 mt-1">Videos Created</div>
      </div>
      <div>
        <div class="text-4xl font-bold text-lime-500">500K+</div>
        <div class="text-gray-600 mt-1">Active Creators</div>
      </div>
      <div>
        <div class="text-4xl font-bold text-emerald-500">4.9/5</div>
        <div class="text-gray-600 mt-1">User Rating</div>
      </div>
    </div> --}}

    <!-- Features Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-5 mt-5">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">
        What you'll get:
      </h2>

      <ul class="space-y-4">
        <li class="flex items-center gap-3">
          <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white">✓</span>
          Create unlimited music videos
        </li>
        <li class="flex items-center gap-3">
          <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white">✓</span>
          No watermarks on exports
        </li>
        <li class="flex items-center gap-3">
          <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white">✓</span>
          All platform formats (Reels, TikTok, Shorts)
        </li>
        <li class="flex items-center gap-3">
          <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white">✓</span>
          Lightning-fast processing
        </li>
        <li class="flex items-center gap-3">
          <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white">✓</span>
          Cloud storage for your creations
        </li>
        <li class="flex items-center gap-3">
          <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-emerald-500 text-white">✓</span>
          Priority support
        </li>
      </ul>
    </div>

    <!-- Bottom Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
      
      <div class="rounded-xl p-6 text-white text-center bg-gradient-to-br from-purple-500 to-pink-500 shadow-lg">
        <div class="text-2xl font-bold mb-1">500K+</div>
        <div class="opacity-90">Users</div>
      </div>

      <div class="rounded-xl p-6 text-white text-center bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg">
        <div class="text-2xl font-bold mb-1">2M+</div>
        <div class="opacity-90">Videos</div>
      </div>

      <div class="rounded-xl p-6 text-white text-center bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg">
        <div class="text-2xl font-bold mb-1">4.9 ★</div>
        <div class="opacity-90">Rating</div>
      </div>

    </div>

  </section>

        <div class="bg-white p-8 lg:p-12 rounded-3xl shadow-xl border border-gray-100">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Create your free account</h2>
            <p class="text-gray-600 mb-8">Start making viral music videos in under 60 seconds. No credit card required.</p>

            <form action="#" method="POST" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block w-full pl-12 p-3.5" placeholder="John Doe" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block w-full pl-12 p-3.5" placeholder="you@example.com" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block w-full pl-12 p-3.5" placeholder="••••••••" required>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Must be at least 8 characters</p>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" required>
                    <label for="terms" class="ml-3 block text-sm text-gray-700">
                        I agree to SnapMusic's <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Terms of Service</a> and <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-full shadow-sm text-lg font-bold btn-gradient hover:opacity-90 bg-gradient-to-r from-yellow-400 to-green-400 focus:ring-purple-500 transition-opacity">
                    Create Account
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-600">
                Already have an account? <a href="#" class="font-medium text-purple-600 hover:text-purple-500">Sign in</a>
            </div>

            {{-- <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-4 bg-white text-sm text-gray-500">Or sign up with</span>
                </div>
            </div> --}}

            {{-- <div class="mt-8 grid grid-cols-2 gap-4">
                <a href="#" class="w-full inline-flex justify-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.46 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Google
                </a>
                <a href="#" class="w-full inline-flex justify-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="h-5 w-5 mr-2 text-gray-900" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                    GitHub
                </a>
            </div> --}}

        </div> 
        </div>
</x-app-layout>