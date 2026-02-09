<x-app-layout>
    <!-- Background Effects -->
    <div class="fixed inset-0 -z-10 overflow-hidden bg-gray-950">
        <!-- Colorful Blobs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/3 left-2/3 w-96 h-96 bg-pink-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob animation-delay-4000"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
    </div>

    <!-- ================= HERO ================= -->
    <section class="relative pt-12 pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-white mb-6">
                Endless <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 animate-gradient-x">Possibilities.</span>
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                See how creators, musicians, and businesses are using SnapMusic to transform their audio into engaging visual experiences.
            </p>
        </div>
    </section>

    <!-- ================= USE CASES GRID ================= -->
    <section class="pb-24 relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
            
                <!-- Musicians -->
                <div class="group relative bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:border-purple-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-500/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-purple-500/20 flex items-center justify-center text-3xl mb-6 shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform duration-300">
                            🎸
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Musicians & Bands</h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            Share your latest demo, a snippet of a new track, or a full song teaser on Instagram and TikTok. SnapMusic makes it easy to turn your audio file into a video ready for social media.
                        </p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Share demos on Instagram Stories
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Create YouTube Art Tracks
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Tease new releases on TikTok
                            </div>
                        </div>

                        <a href="/make-a-video" class="inline-flex items-center gap-2 text-purple-400 font-semibold hover:text-purple-300 transition-colors group-hover:gap-3">
                            Start creating 
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Podcasters -->
                <div class="group relative bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:border-yellow-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-yellow-500/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-yellow-500/20 flex items-center justify-center text-3xl mb-6 shadow-lg shadow-yellow-500/20 group-hover:scale-110 transition-transform duration-300">
                            🎙️
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Podcasters</h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            Turn your podcast highlights into engaging audiograms. Share the best moments of your episode on social platforms where audio-only content isn't supported.
                        </p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Promote new episodes
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Share funny or insightful clips
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Grow your audience on visual platforms
                            </div>
                        </div>

                        <a href="/make-a-video" class="inline-flex items-center gap-2 text-yellow-400 font-semibold hover:text-yellow-300 transition-colors group-hover:gap-3">
                            Start creating 
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Educators -->
                <div class="group relative bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:border-green-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-green-500/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-green-500/20 flex items-center justify-center text-3xl mb-6 shadow-lg shadow-green-500/20 group-hover:scale-110 transition-transform duration-300">
                            🎓
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Educators & Coaches</h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            Share audio lectures, language lessons, or motivational quotes. Combine a relevant image or slide with your voiceover to create a simple, effective educational video.
                        </p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Share daily tips
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Language pronunciation guides
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center text-green-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Mini-lectures for social media
                            </div>
                        </div>

                        <a href="/make-a-video" class="inline-flex items-center gap-2 text-green-400 font-semibold hover:text-green-300 transition-colors group-hover:gap-3">
                            Start creating 
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Marketers -->
                <div class="group relative bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-blue-500/20 flex items-center justify-center text-3xl mb-6 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                            📢
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Marketers</h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            Create simple promotional videos using product photos and a voiceover or jingle. A quick and cost-effective way to generate video ads for various platforms.
                        </p>
                        
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Product feature highlights
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Customer testimonials
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <div class="w-5 h-5 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Event announcements
                            </div>
                        </div>

                        <a href="/make-a-video" class="inline-flex items-center gap-2 text-blue-400 font-semibold hover:text-blue-300 transition-colors group-hover:gap-3">
                            Start creating 
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= CTA ================= -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900/20 pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-8">Ready to turn up the volume?</h2>
            <p class="text-xl text-gray-400 mb-10">
                Join thousands of creators sharing their audio in a whole new way.
            </p>
            <a href="/make-a-video" class="group relative px-8 py-4 rounded-full bg-white text-gray-900 font-bold shadow-[0_0_40px_-10px_rgba(255,255,255,0.3)] hover:shadow-[0_0_60px_-15px_rgba(255,255,255,0.5)] transition-all duration-300 hover:-translate-y-1 inline-block">
                <span class="relative z-10 flex items-center gap-2">
                    Create Your Video Now
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </span>
            </a>
        </div>
    </section>
</x-app-layout>