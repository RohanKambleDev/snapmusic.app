<!-- ================= FOOTER ================= -->
@php
    $isDark = request()->is('/') || request()->routeIs('how-it-works.*') || request()->routeIs('use-case.*');
    $footerBg = $isDark ? 'bg-gray-950 border-white/10' : 'bg-gray-100 border-gray-200';
    $textClass = $isDark ? 'text-gray-400' : 'text-gray-600';
    $logoClass = $isDark ? 'fill-white text-white' : 'fill-black text-black';
@endphp

<footer class="border-t py-12 {{ $footerBg }} transition-colors duration-300">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-1 gap-8 text-sm {{ $textClass }} text-center">

    <div class="flex flex-col items-center">
      <div class="flex items-center justify-center gap-2 font-semibold mb-4">
        <a href="/" class="flex items-center gap-2 hover:opacity-80 transition">
            <x-application-logo class="w-12 h-12 {{ $logoClass }}" />
        </a>
      </div>
      <p class="max-w-xs mx-auto mb-6">Made for creators, big and small. Turn your static images into engaging video content.</p>
    
      <div class="flex gap-6">
          <a href="#" class="hover:text-purple-500 transition">Privacy</a>
          <a href="#" class="hover:text-purple-500 transition">Terms</a>
          <a href="#" class="hover:text-purple-500 transition">Contact</a>
      </div>
    </div>

  </div>

  <p class="text-center text-xs text-gray-500 mt-12">
    Copyright &copy; <script>document.write(new Date().getFullYear())</script> SnapMusic. All rights reserved.
  </p>
</footer>