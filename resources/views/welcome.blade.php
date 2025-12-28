<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SnapMusic – Photo + Music to Video</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    [x-cloak] { display: none !important; }
  </style>

  <!-- Tailwind config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brandGreen: '#22c55e',
            brandYellow: '#facc15',
            brandPurple: '#a855f7',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-white text-gray-900" x-data="{ mobileMenuOpen: false }">

<!-- ================= HEADER ================= -->
<header class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between relative z-50">
  <div class="flex items-center gap-2 font-semibold text-lg">
    <a href="/" class="flex items-center gap-2 hover:text-black">
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-emerald-600"></div>
        <span>SnapMusic</span>
    </a>
  </div>


  <!-- Desktop Nav -->
  <nav class="hidden md:flex items-center gap-8 text-sm text-gray-600">
    <a href="#" class="hover:text-black">Use Cases</a>
    <a href="#" class="hover:text-black">How it Works</a>
    <a href="/videos" class="px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-green-400 text-black font-medium transition hover:shadow-md">
      make a video
    </a>
  </nav>

  <!-- Mobile Menu Button -->
  <div class="md:hidden flex items-center">
    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-black focus:outline-none">
      <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
      </svg>
      <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>

  <!-- Mobile Nav Overlay -->
  <div 
    x-show="mobileMenuOpen" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    @click.away="mobileMenuOpen = false"
    x-cloak
    class="absolute top-full left-0 right-0 m-4 p-6 bg-white shadow-xl rounded-2xl border border-gray-100 md:hidden flex flex-col gap-4 text-gray-600 z-50"
  >
    <a href="#" class="hover:text-black py-2 border-b border-gray-50" @click="mobileMenuOpen = false">Use Cases</a>
    <a href="#" class="hover:text-black py-2 border-b border-gray-50" @click="mobileMenuOpen = false">How it Works</a>
    <a href="/videos" class="mt-2 px-4 py-3 rounded-full bg-gradient-to-r from-yellow-400 to-green-400 text-black font-medium text-center shadow-lg" @click="mobileMenuOpen = false">
      make a video
    </a>
  </div>
</header>

<!-- ================= HERO ================= -->
<section class="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-12 items-center">

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
      <button class="px-6 py-3 rounded-full font-semibold text-white
        bg-gradient-to-r from-yellow-400 via-green-400 to-purple-500
        hover:opacity-90 transition">
        ⚡ Create Video Now
      </button>

      <button class="px-6 py-3 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
        ⬇ Download App
      </button>
    </div>
  </div>

  <!-- Right (Mock UI) -->
  <div class="relative">
    <div class="rounded-2xl shadow-xl bg-gray-900 p-4 w-full max-w-md mx-auto">
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
    </div>
  </div>
</section>

<!-- ================= PROBLEM ================= -->
<section class="bg-gray-50 py-16">
  <div class="max-w-7xl mx-auto px-6 text-center">
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
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h2 class="text-2xl font-semibold mb-12">
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

    <button class="mt-10 px-8 py-3 rounded-full text-white font-semibold
      bg-gradient-to-r from-yellow-400 via-green-400 to-purple-500 hover:opacity-90">
      ⚡ Start Creating Now
    </button>
  </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="border-t py-10">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-sm text-gray-600">

    <div>
      <div class="flex items-center gap-2 font-semibold text-black mb-2">
        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-400 to-emerald-600"></div>
        SnapMusic
      </div>
      Made for creators, big and small.
    </div>

    <div>
      <h4 class="font-medium text-black mb-2">Quick Links</h4>
      <ul class="space-y-1">
        <li><a href="#" class="hover:text-black">Privacy</a></li>
        <li><a href="#" class="hover:text-black">Terms</a></li>
        <li><a href="#" class="hover:text-black">Contact</a></li>
      </ul>
    </div>

    <div>
      <h4 class="font-medium text-black mb-2">Follow Us</h4>
      <div class="flex gap-4 text-xl">
        📸 🎵
      </div>
    </div>
  </div>

  <p class="text-center text-xs text-gray-400 mt-8">
    © 2025 SnapMusic. All rights reserved.
  </p>
</footer>

</body>
</html>
