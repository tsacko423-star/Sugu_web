<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sugu Web') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="{{ asset('css/sugu-style.css') }}" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-gray-100 antialiased bg-primary-bg">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="{{ route('home') }}" class="navbar-brand text-white fw-bold">SugWeb</a>   
            </div>
            {{-- Icônes de droite --}}
            <div class="d-flex align-items-center gap-3 flex-wrap py-3 py-lg-0">
                {{-- Icône : Publier une annonce --}}
                <a href="{{ route('login') }}"
                   title="Publier une annonce"
                   class="d-flex align-items-center gap-2 text-decoration-none"
                   style="background: #f5c518; color: #1a1a1a; padding: 0.45rem 1rem; border-radius: 999px; font-weight: 700; font-size: 0.85rem; transition: background 0.2s;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="16"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                    <span class="d-none d-md-inline">Publier</span>
                </a>

           


            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-secondary-bg shadow-md overflow-hidden sm:rounded-3xl border border-white border-opacity-10">
                {{ $slot }}
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
