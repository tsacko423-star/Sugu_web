@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sugu-accent text-sm font-medium leading-5 text-sugu-text focus:outline-none focus:border-sugu-accent-hover transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-sugu-text-muted hover:text-sugu-text hover:border-sugu-border focus:outline-none focus:text-sugu-text focus:border-sugu-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
