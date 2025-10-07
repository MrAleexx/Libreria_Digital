<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Grupo A&T - @yield('titulo')</title>

        {{-- Google Fonts - Poppins --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        {{-- Styles - Scripts --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body>
        <header>
            {{-- @include('layouts.includes.top-bar') --}}

            @include('layouts.includes.navegacion')
        </header>

        <main>
            @yield('contenido')
        </main>

        <footer class="bg-[#222222]">
            @include('layouts.includes.footer')
        </footer>

        @yield('scripts')
        
    </body>
</html>
