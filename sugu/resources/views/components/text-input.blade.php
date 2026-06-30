@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-sugu-border bg-sugu-bg-card text-sugu-text focus:border-sugu-accent focus:ring-sugu-accent rounded-md shadow-sm']) }}>
