<x-app-layout>
    <!-- Background Effects -->
    <div class="fixed inset-0 -z-10 overflow-hidden bg-gray-950">
        <!-- Colorful Blobs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-yellow-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob animation-delay-4000"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
    </div>

    <!-- ================= HERO ================= -->
    <section class="relative pt-8 pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left: Text Content -->
            <div class="text-center lg:text-left z-10">
                <div class="inline-flex items-center px-3 py-1 rounded-full border border-purple-500/30 bg-purple-500/10 text-purple-300 text-xs font-medium mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-purple-400 mr-2 animate-pulse"></span>
                    Now in Beta
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-white leading-[1.1]">
                    Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-pink-400 to-purple-500 animate-gradient-x">Snap</span> <br />
                    deserves a <br />
                    meaningful <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-pink-400 to-purple-500 animate-gradient-x">Music</span>
                </h1>

                <p class="mt-6 text-lg text-gray-400 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Combine your favorite image with audio instantly. No complex timelines, no watermarks. Just pure creativity in seconds.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="/make-a-video" class="group relative px-8 py-4 rounded-full bg-white text-gray-900 font-bold shadow-[0_0_40px_-10px_rgba(255,255,255,0.3)] hover:shadow-[0_0_60px_-15px_rgba(255,255,255,0.5)] transition-all duration-300 hover:-translate-y-1">
                        <span class="relative z-10 flex items-center gap-2">
                            Create SnapMusic
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </span>
                    </a>
                    
                    <a href="#how-it-works" class="px-8 py-4 rounded-full text-white font-medium border border-white/10 hover:bg-white/5 transition-colors">
                        How it works
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="mt-12 flex items-center justify-center lg:justify-start gap-6 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                    <!-- Placeholder Logos -->
                    <div class="h-6 w-20 bg-white/20 rounded"></div>
                    <div class="h-6 w-20 bg-white/20 rounded"></div>
                    <div class="h-6 w-20 bg-white/20 rounded"></div>
                </div>
            </div>

            <!-- Right: Interactive 3D/Glass Element -->
            <div class="relative lg:h-[600px] flex items-center justify-center perspective-1000">
                <!-- Glowing Backdrop -->
                <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/30 to-yellow-500/30 rounded-full blur-[100px] animate-pulse"></div>

                <!-- Main Glass Card -->
                <div class="relative w-full max-w-md aspect-[4/5] bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl ring-1 ring-white/10 transform rotate-y-12 rotate-x-6 hover:rotate-0 transition-transform duration-700 ease-out preserve-3d">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="text-xs font-mono text-gray-500">preview.mp4</div>
                    </div>

                    <!-- Video Preview Area -->
                    <div class="relative w-full aspect-square rounded-2xl overflow-hidden bg-gray-800 border border-white/5 group">
                        <!-- Image Layer -->
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-pink-500 opacity-80 group-hover:scale-110 transition-transform duration-1000"></div>
                        
                        <!-- Overlay Text -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-white z-10">
                            <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center mb-4 border border-white/20 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 fill-current translate-x-1" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                            <p class="font-medium text-lg drop-shadow-md">Summer Vibes</p>
                            <p class="text-sm text-white/70">Original Audio</p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/20">
                            <div class="h-full w-1/3 bg-white shadow-[0_0_10px_white]"></div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-purple-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full w-2/3 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-pulse"></div>
                                </div>
                                <div class="flex justify-between mt-2 text-xs text-gray-400">
                                    <span>Processing...</span>
                                    <span>68%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -right-12 top-20 w-24 h-24 bg-gray-800/80 backdrop-blur-md rounded-2xl border border-white/10 p-3 shadow-2xl animate-float" style="animation-delay: 1s;">
                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-cyan-300 rounded-lg"></div>
                    </div>
                    <div class="absolute -left-8 bottom-32 w-20 h-20 bg-gray-800/80 backdrop-blur-md rounded-2xl border border-white/10 p-3 shadow-2xl animate-float" style="animation-delay: 2s;">
                        <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= HOW IT WORKS ================= -->
    <section id="how-it-works" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4"> effortless creation.</h2>
                <p class="text-gray-400">Three simple steps to your next masterpiece.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-purple-500/50 to-transparent -translate-y-1/2 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 group">
                    <div class="w-full aspect-[4/3] bg-gray-900/50 backdrop-blur-sm border border-white/10 rounded-2xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 hover:border-purple-500/50 hover:bg-gray-800/50 hover:-translate-y-2 shadow-lg hover:shadow-purple-500/20">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-2xl mb-6 shadow-lg shadow-purple-500/30">
                            📷
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Upload Photo</h3>
                        <p class="text-sm text-gray-400">Choose any JPG or PNG. High resolution works best.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 group">
                    <div class="w-full aspect-[4/3] bg-gray-900/50 backdrop-blur-sm border border-white/10 rounded-2xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 hover:border-pink-500/50 hover:bg-gray-800/50 hover:-translate-y-2 shadow-lg hover:shadow-pink-500/20">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-500 to-orange-500 flex items-center justify-center text-2xl mb-6 shadow-lg shadow-pink-500/30">
                            🎵
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Add Audio</h3>
                        <p class="text-sm text-gray-400">Upload your track. We loop the image to match the beat.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 group">
                    <div class="w-full aspect-[4/3] bg-gray-900/50 backdrop-blur-sm border border-white/10 rounded-2xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 hover:border-green-500/50 hover:bg-gray-800/50 hover:-translate-y-2 shadow-lg hover:shadow-green-500/20">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-2xl mb-6 shadow-lg shadow-green-500/30">
                            ✨
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Export Audio Image</h3>
                        <p class="text-sm text-gray-400">Get a polished MP4 ready for TikTok, Reels, or Shorts.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FEATURES GRID ================= -->
    <section class="py-24 bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 blur-[80px] opacity-20"></div>
                    <div class="relative bg-black/40 border border-white/10 rounded-3xl p-8 backdrop-blur-xl">
                        <!-- Mockup of a waveform or editor -->
                        <div class="space-y-4">
                            <div class="h-32 rounded-xl bg-gray-800/50 border border-white/5 flex items-center justify-center">
                                <div class="flex gap-1 items-end h-16">
                                    <div class="w-2 bg-purple-500 h-8 rounded-full animate-pulse"></div>
                                    <div class="w-2 bg-purple-500 h-12 rounded-full animate-pulse delay-75"></div>
                                    <div class="w-2 bg-purple-500 h-6 rounded-full animate-pulse delay-150"></div>
                                    <div class="w-2 bg-purple-500 h-10 rounded-full animate-pulse delay-100"></div>
                                    <div class="w-2 bg-purple-500 h-14 rounded-full animate-pulse delay-200"></div>
                                    <div class="w-2 bg-purple-500 h-8 rounded-full animate-pulse delay-75"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 font-mono">
                                <span>00:00</span>
                                <span>00:15</span>
                                <span>00:30</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 md:order-2">
                    <h2 class="text-3xl font-bold text-white mb-6">Designed for creators.</h2>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Lightning Fast</h4>
                                <p class="text-gray-400 text-sm mt-1">Render videos in seconds, not minutes. Our cloud infrastructure handles the heavy lifting.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center text-pink-400 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Private & Secure</h4>
                                <p class="text-gray-400 text-sm mt-1">Your files are automatically deleted after processing. We don't store your content.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CTA ================= -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-purple-900/20"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-8">Ready to make noise?</h2>
            <p class="text-xl text-gray-400 mb-10">Join thousands of creators sharing their music visually.</p>
            
            <a href="/make-a-video">
                <button class="px-10 py-5 rounded-full bg-white text-black font-bold text-lg shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:scale-105 transition-transform duration-300">
                    Get Started for Free
                </button>
            </a>
        </div>
    </section>

</x-app-layout>