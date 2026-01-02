<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

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

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])