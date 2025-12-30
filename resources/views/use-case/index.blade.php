<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SnapMusic – Use Cases</title>
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
      Endless Possibilities.
    </h1>
    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
      See how creators, musicians, and businesses are using SnapMusic to share their audio content visually.
    </p>
  </div>
</section>

<!-- ================= USE CASES GRID ================= -->
<section class="py-20">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 gap-12">
      
      <!-- Musicians -->
      <div class="rounded-3xl border border-gray-100 shadow-xl overflow-hidden hover:shadow-2xl transition">
        <div class="bg-purple-100 h-64 flex items-center justify-center text-6xl">
          🎸
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold mb-3">Musicians & Bands</h3>
          <p class="text-gray-600 mb-6">
            Share your latest demo, a snippet of a new track, or a full song teaser on Instagram and TikTok. SnapMusic makes it easy to turn your audio file into a video ready for social media.
          </p>
          <ul class="space-y-2 mb-8 text-sm text-gray-500">
            <li class="flex items-center gap-2">✅ Share demos on Instagram Stories</li>
            <li class="flex items-center gap-2">✅ Create YouTube Art Tracks</li>
            <li class="flex items-center gap-2">✅ Tease new releases on TikTok</li>
          </ul>
          <a href="/videos" class="text-brandPurple font-semibold hover:underline">Start creating &rarr;</a>
        </div>
      </div>

      <!-- Podcasters -->
      <div class="rounded-3xl border border-gray-100 shadow-xl overflow-hidden hover:shadow-2xl transition">
        <div class="bg-yellow-100 h-64 flex items-center justify-center text-6xl">
          🎙️
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold mb-3">Podcasters</h3>
          <p class="text-gray-600 mb-6">
            Turn your podcast highlights into engaging audiograms. Share the best moments of your episode on social platforms where audio-only content isn't supported.
          </p>
          <ul class="space-y-2 mb-8 text-sm text-gray-500">
            <li class="flex items-center gap-2">✅ Promote new episodes</li>
            <li class="flex items-center gap-2">✅ Share funny or insightful clips</li>
            <li class="flex items-center gap-2">✅ Grow your audience on visual platforms</li>
          </ul>
          <a href="/videos" class="text-yellow-600 font-semibold hover:underline">Start creating &rarr;</a>
        </div>
      </div>

      <!-- Educators -->
      <div class="rounded-3xl border border-gray-100 shadow-xl overflow-hidden hover:shadow-2xl transition">
        <div class="bg-green-100 h-64 flex items-center justify-center text-6xl">
          🎓
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold mb-3">Educators & Coaches</h3>
          <p class="text-gray-600 mb-6">
            Share audio lectures, language lessons, or motivational quotes. Combine a relevant image or slide with your voiceover to create a simple, effective educational video.
          </p>
          <ul class="space-y-2 mb-8 text-sm text-gray-500">
            <li class="flex items-center gap-2">✅ Share daily tips</li>
            <li class="flex items-center gap-2">✅ Language pronunciation guides</li>
            <li class="flex items-center gap-2">✅ Mini-lectures for social media</li>
          </ul>
          <a href="/videos" class="text-brandGreen font-semibold hover:underline">Start creating &rarr;</a>
        </div>
      </div>

      <!-- Marketers -->
      <div class="rounded-3xl border border-gray-100 shadow-xl overflow-hidden hover:shadow-2xl transition">
        <div class="bg-blue-100 h-64 flex items-center justify-center text-6xl">
          📢
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold mb-3">Marketers</h3>
          <p class="text-gray-600 mb-6">
            Create simple promotional videos using product photos and a voiceover or jingle. A quick and cost-effective way to generate video ads for various platforms.
          </p>
          <ul class="space-y-2 mb-8 text-sm text-gray-500">
            <li class="flex items-center gap-2">✅ Product feature highlights</li>
            <li class="flex items-center gap-2">✅ Customer testimonials</li>
            <li class="flex items-center gap-2">✅ Event announcements</li>
          </ul>
          <a href="/videos" class="text-blue-600 font-semibold hover:underline">Start creating &rarr;</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= CTA ================= -->
<section class="bg-gray-900 text-white py-20 text-center">
  <div class="max-w-4xl mx-auto px-6">
    <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to turn up the volume?</h2>
    <p class="text-gray-400 mb-10 text-lg">
      Join thousands of creators sharing their audio in a whole new way.
    </p>
    <a href="/videos" class="inline-block px-8 py-4 rounded-full font-semibold text-gray-900 bg-gradient-to-r from-yellow-400 via-green-400 to-purple-500 hover:opacity-90 transition transform hover:scale-105">
      🚀 Create Your Video Now
    </a>
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
