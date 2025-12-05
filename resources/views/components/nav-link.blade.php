@props(['active'])

@php
$classes = ($active ?? false)
            ? 'relative px-3 py-2 text-sm font-medium transition-all duration-300 rounded-lg group text-white bg-white/10'
            : 'relative px-3 py-2 text-sm font-medium transition-all duration-300 rounded-lg group text-slate-400 hover:text-white hover:bg-white/5';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
