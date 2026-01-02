<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SnapMusic – How It Works</title>
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

<body class="bg-white text-gray-900">

<!-- ================= HEADER ================= -->
@include('layouts.navigation')

<!-- ================= HERO ================= -->
<section class="bg-gray-50 py-20">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
      Simple. Fast. Creative.
    </h1>
    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
      Create stunning videos in just a few clicks. No complex timelines, no rendering wait times.
    </p>
  </div>
</section>

<!-- ================= INTERACTIVE STEPS ================= -->
<section class="py-20" x-data="{ activeStep: 1 }">
  <div class="max-w-6xl mx-auto px-6">
    
    <!-- Step Navigation -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-16">
      
      <button 
        @click="activeStep = 1" 
        :class="activeStep === 1 ? 'bg-brandYellow text-black shadow-lg scale-105' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
        class="px-8 py-4 rounded-full font-bold transition-all duration-300 w-full md:w-auto text-center"
      >
        1. Select Media
      </button>

      <div class="hidden md:block w-12 h-1 bg-gray-200"></div>

      <button 
        @click="activeStep = 2"
        :class="activeStep === 2 ? 'bg-brandGreen text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
        class="px-8 py-4 rounded-full font-bold transition-all duration-300 w-full md:w-auto text-center"
      >
        2. Processing
      </button>

      <div class="hidden md:block w-12 h-1 bg-gray-200"></div>

      <button 
        @click="activeStep = 3"
        :class="activeStep === 3 ? 'bg-brandPurple text-white shadow-lg scale-105' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
        class="px-8 py-4 rounded-full font-bold transition-all duration-300 w-full md:w-auto text-center"
      >
        3. Download
      </button>

    </div>

    <!-- Step Content -->
    <div class="grid md:grid-cols-2 gap-12 items-center min-h-[400px]">
      
      <!-- Text Content -->
      <div class="order-2 md:order-1">
        
        <!-- Step 1 Info -->
        <div x-show="activeStep === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
          <h3 class="text-3xl font-bold mb-4">Choose Your Assets</h3>
          <p class="text-gray-600 text-lg mb-6 leading-relaxed">
            Start by uploading a high-quality static image (JPG/PNG) and your audio track (MP3/WAV). Our smart validator ensures your files are optimized for video creation.
          </p>
          <ul class="space-y-3 text-gray-700">
            <li class="flex items-center gap-3">
              <span class="text-brandYellow text-xl">📷</span> Supports any image aspect ratio
            </li>
            <li class="flex items-center gap-3">
              <span class="text-brandYellow text-xl">🎵</span> Handles high-bitrate audio
            </li>
            <li class="flex items-center gap-3">
              <span class="text-brandYellow text-xl">✨</span> Drag-and-drop interface
            </li>
          </ul>
        </div>

        <!-- Step 2 Info -->
        <div x-show="activeStep === 2" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
          <h3 class="text-3xl font-bold mb-4">Instant Generation</h3>
          <p class="text-gray-600 text-lg mb-6 leading-relaxed">
            Our powerful cloud engine combines your assets using industry-standard FFmpeg encoding. We resize your image to ensure compatibility across all devices and platforms.
          </p>
          <ul class="space-y-3 text-gray-700">
            <li class="flex items-center gap-3">
              <span class="text-brandGreen text-xl">⚡</span> H.264 Video Encoding
            </li>
            <li class="flex items-center gap-3">
              <span class="text-brandGreen text-xl">🎯</span> Automatic dimension fixing
            </li>
            <li class="flex items-center gap-3">
              <span class="text-brandGreen text-xl">🔄</span> Loops video to match audio length
            </li>
          </ul>
        </div>

        <!-- Step 3 Info -->
        <div x-show="activeStep === 3" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
          <h3 class="text-3xl font-bold mb-4">Ready to Share</h3>
          <p class="text-gray-600 text-lg mb-6 leading-relaxed">
            Once processing is complete, your video is ready instantly. Preview it right in the browser or download the MP4 file to share on Instagram, TikTok, YouTube, or WhatsApp.
          </p>
          <ul class="space-y-3 text-gray-700">
            <li class="flex items-center gap-3">
              <span class="text-brandPurple text-xl">📥</span> Direct MP4 Download
            </li>
            <li class="flex items-center gap-3">
              <span class="text-brandPurple text-xl">👁️</span> Instant Web Preview
            </li>
            <li class="flex items-center gap-3">
              <span class="text-brandPurple text-xl">🗑️</span> Auto-cleanup of source files
            </li>
          </ul>
          <a href="/videos" class="inline-block mt-6 px-6 py-3 bg-brandPurple text-white rounded-lg font-semibold hover:opacity-90 transition">
            Start Creating Now
          </a>
        </div>

      </div>

      <!-- Visual Content (Placeholder for Screenshot) -->
      <div class="order-1 md:order-2 bg-gray-100 rounded-3xl p-8 shadow-inner flex items-center justify-center min-h-[300px]">
        
        <div x-show="activeStep === 1" x-transition:enter="transition ease-in duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
          <div class="text-center">
            <div class="text-8xl mb-4">📂</div>
            <div class="text-gray-400 font-medium">Upload Interface</div>
          </div>
        </div>

        <div x-show="activeStep === 2" x-cloak x-transition:enter="transition ease-in duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
          <div class="text-center">
            <div class="text-8xl mb-4 animate-pulse">⚙️</div>
            <div class="text-gray-400 font-medium">Processing Engine</div>
          </div>
        </div>

        <div x-show="activeStep === 3" x-cloak x-transition:enter="transition ease-in duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
          <div class="text-center">
            <div class="text-8xl mb-4">🎬</div>
            <div class="text-gray-400 font-medium">Final Video</div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="border-t py-10">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-sm text-gray-600">

    <div>
      <div class="flex items-center gap-2 font-semibold text-black mb-2">
        <x-application-logo class="w-6 h-6" />
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