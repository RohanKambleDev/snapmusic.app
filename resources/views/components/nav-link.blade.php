@props(['active'])

@php
$classes = ($active ?? false)
            ? 'active ' . $attributes->get('class')
            : $attributes->get('class');
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>