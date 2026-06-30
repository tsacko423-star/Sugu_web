@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-sugu-text']) }}>
    {{ $value ?? $slot }}
</label>
