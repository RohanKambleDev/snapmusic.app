<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 relative">
        <!-- Ambient Background -->
        <div class="fixed inset-0 pointer-events-none -z-10">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-pink-600/10 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/10 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- User Overview Card -->
            <div class="p-8 rounded-3xl bg-gray-900/50 backdrop-blur-xl border border-white/10 shadow-2xl flex flex-col md:flex-row items-center gap-8">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white/10 shadow-lg group-hover:border-purple-500/50 transition-colors">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-4xl text-white font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <!-- Edit overlay handled by the form below, but visually we can hint it -->
                </div>
                
                <div class="text-center md:text-left flex-1">
                    <h3 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h3>
                    <p class="text-gray-400 text-lg mb-4">{{ $user->email }}</p>
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        <span class="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-sm text-gray-300">
                            Member since {{ $user->created_at->format('M Y') }}
                        </span>
                        {{-- <span class="px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-sm text-purple-300">
                            Pro Plan
                        </span> --}}
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <button onclick="document.getElementById('profile-info-section').scrollIntoView({ behavior: 'smooth' })" 
                            class="px-6 py-3 rounded-full bg-white text-gray-900 font-bold hover:bg-gray-200 transition shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Edit Profile
                    </button>
                </div>
            </div>

            <!-- Forms Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Profile Info Form -->
                <div id="profile-info-section" class="p-8 rounded-3xl bg-gray-900/50 backdrop-blur-xl border border-white/10 shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile Information
                    </h3>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password Form -->
                <div class="p-8 rounded-3xl bg-gray-900/50 backdrop-blur-xl border border-white/10 shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Update Password
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account -->
                <div class="lg:col-span-2 p-8 rounded-3xl bg-red-900/10 backdrop-blur-xl border border-red-500/20 shadow-lg">
                    <h3 class="text-xl font-bold text-red-200 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Account
                    </h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>