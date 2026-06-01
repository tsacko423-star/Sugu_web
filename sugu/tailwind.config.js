import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                sugu: {
                    primary: '#1e3a5f',
                    'primary-dark': '#0f1f33',
                    secondary: '#2d5a87',
                    accent: '#f97316',
                    'accent-hover': '#ea580c',
                    'bg-dark': '#0a0f1a',
                    'bg-card': '#111827',
                    'bg-sidebar': '#0d1421',
                    border: '#1f2937',
                    text: '#f8fafc',
                    'text-muted': '#94a3b8',
                    success: '#10b981',
                    warning: '#f59e0b',
                    danger: '#ef4444',
                    info: '#3b82f6',
                }
            },
        },
    },

    plugins: [forms],
};
