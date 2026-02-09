<x-app-layout>
    <!-- Background Effects -->
    <div class="fixed inset-0 -z-10 overflow-hidden bg-gray-950">
        <!-- Colorful Blobs -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-green-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-purple-500/20 rounded-full mix-blend-screen filter blur-[128px] animate-blob animation-delay-2000"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
    </div>

    <!-- ================= HERO ================= -->
    <section class="pt-12 pb-20 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Under the <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400 animate-gradient-x">Hood.</span>
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                How SnapMusic transforms your static assets into viral videos using robust cloud engineering.
            </p>
        </div>
    </section>

    <!-- ================= VISUAL FLOW DIAGRAM ================= -->
    <section class="py-12 relative">
        <div class="max-w-6xl mx-auto px-6">
            
            <!-- Process Flow -->
            <div class="relative flex flex-col md:flex-row justify-between items-center gap-8 z-10">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-green-500 opacity-30 -z-10"></div>
                
                <!-- Step 1: Upload -->
                <div class="group relative w-full md:w-1/3 p-6 bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-2xl hover:bg-gray-800/60 transition-all duration-300 hover:-translate-y-2">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/40 z-20">1</div>
                    <div class="text-center mt-6">
                        <div class="text-4xl mb-4">📤</div>
                        <h3 class="text-xl font-bold text-white mb-2">Upload & Validate</h3>
                        <p class="text-sm text-gray-400">User uploads Image (JPG/PNG) & Audio (MP3/WAV). System validates mime-types and file integrity.</p>
                        <div class="mt-4 p-3 bg-black/30 rounded-lg border border-white/5 font-mono text-xs text-blue-300 text-left">
                            POST /upload<br/>
                            Content-Type: multipart/form-data
                        </div>
                    </div>
                </div>

                <!-- Step 2: Queue & Process -->
                <div class="group relative w-full md:w-1/3 p-6 bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-2xl hover:bg-gray-800/60 transition-all duration-300 hover:-translate-y-2">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-500/40 z-20">2</div>
                    <div class="text-center mt-6">
                        <div class="text-4xl mb-4 animate-pulse">⚙️</div>
                        <h3 class="text-xl font-bold text-white mb-2">Queue & Encode</h3>
                        <p class="text-sm text-gray-400">Job pushed to queue. Worker picks it up and triggers FFmpeg conversion.</p>
                        <div class="mt-4 p-3 bg-black/30 rounded-lg border border-white/5 font-mono text-xs text-purple-300 text-left">
                            App\Jobs\ProcessVideoJob<br/>
                            dispatch($video)
                        </div>
                    </div>
                </div>

                <!-- Step 3: Storage & Stream -->
                <div class="group relative w-full md:w-1/3 p-6 bg-gray-900/40 backdrop-blur-xl border border-white/10 rounded-2xl hover:bg-gray-800/60 transition-all duration-300 hover:-translate-y-2">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-green-500/40 z-20">3</div>
                    <div class="text-center mt-6">
                        <div class="text-4xl mb-4">💾</div>
                        <h3 class="text-xl font-bold text-white mb-2">Store & Notify</h3>
                        <p class="text-sm text-gray-400">MP4 stored in private storage. Frontend polls for completion status.</p>
                        <div class="mt-4 p-3 bg-black/30 rounded-lg border border-white/5 font-mono text-xs text-green-300 text-left">
                            Status: COMPLETED<br/>
                            storage/app/videos/{id}.mp4
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= TECHNICAL DEEP DIVE ================= -->
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-12">
            
            <!-- FFmpeg Details -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center text-red-400">📹</span>
                    The FFmpeg Engine
                </h2>
                <p class="text-gray-400 leading-relaxed">
                    We use FFmpeg to combine the static image and audio stream. Crucially, we apply a complex filter to ensure compatibility across all players.
                </p>
                
                <div class="bg-black/50 rounded-xl border border-white/10 p-5 overflow-x-auto">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Scale Filter Logic</h4>
                    <code class="font-mono text-sm text-green-400">
                        scale=trunc(iw/2)*2:trunc(ih/2)*2
                    </code>
                    <p class="text-xs text-gray-500 mt-3">
                        <strong class="text-gray-300">Why?</strong> H.264 encoding requires even dimensions. This filter forces width and height to be divisible by 2, preventing encoding errors on odd-sized user images.
                    </p>
                </div>
            </div>

            <!-- Queue Worker Details -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-yellow-500/20 flex items-center justify-center text-yellow-400">⚡</span>
                    Async Queue Workers
                </h2>
                <p class="text-gray-400 leading-relaxed">
                    Video processing is heavy. To keep the UI snappy, we offload the heavy lifting to background workers.
                </p>
                
                <div class="bg-black/50 rounded-xl border border-white/10 p-5 overflow-x-auto">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Worker Command</h4>
                    <code class="font-mono text-sm text-yellow-400">
                        php artisan queue:work --tries=3 --timeout=120
                    </code>
                    <p class="text-xs text-gray-500 mt-3">
                        <strong class="text-gray-300">How it works:</strong> The web request finishes instantly, returning a "Pending" status. The worker picks up the job, runs FFmpeg, and updates the database state to "Completed".
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- ================= SYSTEM ARCHITECTURE (MERMAID STYLE) ================= -->
    <section class="py-16 bg-gray-900/30 border-y border-white/5">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold text-white mb-10">System Data Flow</h2>
            
            <div class="relative p-8 bg-gray-900 rounded-2xl border border-white/10 shadow-2xl overflow-hidden font-mono text-xs md:text-sm text-gray-300">
                <div class="flex flex-col gap-6 items-center">
                    
                    <!-- Client -->
                    <div class="flex items-center gap-4 w-full justify-center">
                        <div class="px-6 py-3 rounded-lg border border-blue-500/50 bg-blue-500/10 text-blue-300">Client (Browser)</div>
                    </div>
                    
                    <div class="h-8 w-0.5 bg-gray-700 relative"><span class="absolute top-1/2 left-2 -translate-y-1/2 text-[10px] text-gray-500 whitespace-nowrap">POST /videos</span></div>
                    
                    <!-- Web Server -->
                    <div class="flex items-center gap-4 w-full justify-center">
                        <div class="px-6 py-3 rounded-lg border border-purple-500/50 bg-purple-500/10 text-purple-300">Laravel Web Server</div>
                    </div>

                    <div class="grid grid-cols-2 gap-8 w-full max-w-md">
                        <div class="flex flex-col items-center">
                            <div class="h-8 w-0.5 bg-gray-700"></div>
                            <div class="px-4 py-2 rounded border border-gray-600 bg-gray-800">Database (Job Created)</div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="h-8 w-0.5 bg-gray-700 relative"><span class="absolute top-1/2 left-2 -translate-y-1/2 text-[10px] text-gray-500">Dispatch</span></div>
                            <div class="px-4 py-2 rounded border border-yellow-500/50 bg-yellow-500/10 text-yellow-300">Queue Worker</div>
                        </div>
                    </div>

                    <div class="w-full max-w-md border-l-2 border-dashed border-gray-700 h-8 ml-auto mr-auto translate-x-1/4"></div>

                    <!-- FFmpeg -->
                    <div class="flex items-center gap-4 w-full justify-center">
                        <div class="px-6 py-3 rounded-lg border border-red-500/50 bg-red-500/10 text-red-300">FFmpeg Process</div>
                    </div>

                    <div class="h-8 w-0.5 bg-gray-700"></div>

                    <!-- Storage -->
                    <div class="flex items-center gap-4 w-full justify-center">
                        <div class="px-6 py-3 rounded-lg border border-green-500/50 bg-green-500/10 text-green-300">Storage (MP4)</div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</x-app-layout>