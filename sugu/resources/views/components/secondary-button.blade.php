<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-sugu-bg-card border border-sugu-border rounded-md font-semibold text-xs text-sugu-text uppercase tracking-widest shadow-sm hover:bg-sugu-primary focus:outline-none focus:ring-2 focus:ring-sugu-secondary disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
