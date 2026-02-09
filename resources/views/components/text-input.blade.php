@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-gray-900/50 border border-white/10 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm placeholder-gray-500']) }}>
