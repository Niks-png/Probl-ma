<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Find the best prices on products from top online stores">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title', 'Price Finder')</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            <x-navbar />
        </header>
        
        <main class="content" role="main">
            @yield('content')
        </main>
        
        <footer class="footer" role="contentinfo">
            <p>&copy; {{ date('Y') }} Price Finder. All rights reserved.</p>
        </footer>
    </body>
</html>
