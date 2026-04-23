<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins&display=swap" rel="stylesheet">

    <!-- Ton CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts (Laravel Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <body>

    {{-- Navbar --}}
    @include('profile.partials.navbar')

    {{-- Contenu des pages --}}
    @yield('content')

    {{-- Footer --}}
    @include('profile.partials.footer')

</body>
</html>
