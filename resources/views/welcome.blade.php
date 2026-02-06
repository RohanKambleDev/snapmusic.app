<x-app-layout>

<!-- ================= HERO ================= -->
<section class="max-w-7xl mx-auto px-12 py-16 grid md:grid-cols-2 gap-12 items-center">

  <!-- Left -->
  <div>
    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
      The fastest way to turn<br />
      a photo & song into a<br />
      video.
    </h1>

    <p class="mt-6 text-gray-600 max-w-md">
      No timeline. No complex editing. Just pick your media and export instantly
      for Reels, Status, and Shorts.
    </p>

    <div class="mt-8 flex flex-wrap gap-4">
        <a href="/make-a-video">
            <button class="px-6 py-3 rounded-full font-semibold text-white
            bg-gradient-to-r from-yellow-400 via-green-400 to-purple-500
            hover:opacity-90 transition">
                ⚡ Create Video Now
            </button>
        </a>

      {{-- <button class="px-6 py-3 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
        ⬇ Download App
      </button> --}}
    </div>
  </div>

  <!-- Right (Mock UI) -->
  <div class="relative">


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

    {{-- <div class="rounded-2xl shadow-xl bg-gray-900 p-4 w-full max-w-md mx-auto">
      <div class="grid grid-cols-2 gap-4">
        <!-- Photo -->
        <div class="rounded-xl bg-orange-200 h-48 flex items-center justify-center">
          <span class="text-gray-500 text-sm">📷 Photo</span>
        </div>

        <!-- Playing -->
        <div class="rounded-xl bg-gradient-to-br from-pink-400 to-purple-500 h-48 flex items-center justify-center text-white">
          ✨ Playing…
        </div>
      </div>

      <div class="mt-4 text-xs text-gray-400 flex items-center gap-2">
        🎵 Summer Vibes.mp3
      </div>
    </div> --}}
  </div>
</section>

<!-- ================= PROBLEM ================= -->
<section class="bg-gray-100 py-16">
  <div class="max-w-7xl mx-auto px-12 text-center">
    <h2 class="text-2xl font-semibold mb-10">
      Why is sharing music so hard?
    </h2>

    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="text-red-400 text-3xl mb-3">😕</div>
        <p class="text-sm text-gray-600">
          Video editors are too complex for simple posts.
        </p>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="text-orange-400 text-3xl mb-3">🚫</div>
        <p class="text-sm text-gray-600">
          WhatsApp Status doesn’t support music stickers.
        </p>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="text-purple-400 text-3xl mb-3">👻</div>
        <p class="text-sm text-gray-600">
          Story stickers are temporary — you can’t save the video.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ================= STEPS ================= -->
<section class="py-20">
  <div class="max-w-7xl mx-auto px-12 text-center">
    <h2 class="text-2xl font-semibold mb-5">
      3 Steps to Viral.
    </h2>

    <div class="flex flex-col md:flex-row items-center justify-center gap-8">

      <div class="w-40 h-32 rounded-xl bg-yellow-400 text-white flex flex-col items-center justify-center shadow">
        📷
        <span class="text-sm mt-2 font-medium">Step 1: Pick Photo</span>
      </div>

      <span class="text-gray-400 text-2xl">→</span>

      <div class="w-40 h-32 rounded-xl bg-green-400 text-white flex flex-col items-center justify-center shadow">
        🎵
        <span class="text-sm mt-2 font-medium">Step 2: Pick Audio</span>
      </div>

      <span class="text-gray-400 text-2xl">→</span>

      <div class="w-40 h-32 rounded-xl bg-purple-400 text-white flex flex-col items-center justify-center shadow">
        🎬
        <span class="text-sm mt-2 font-medium">Step 3: Export</span>
      </div>
    </div>

    <a href="/make-a-video">
        <button class="mt-10 px-8 py-3 rounded-full text-white font-semibold
        bg-gradient-to-r from-yellow-400 via-green-400 to-purple-500 hover:opacity-90">
            ⚡ Start Creating Now
        </button>
    </a>
  </div>
</section>

</x-app-layout>