<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hydrogen Hub</title>

    <!-- Fonts -->
    <link href="http://fonts.cdnfonts.com/css/effra" rel="stylesheet">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Effra', sans-serif;
        }
        #menu{
            background: #003399;
        }
    </style>
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @livewireStyles
</head>
    <body class="h-screen">

        <div class="grid grid-cols-8 h-screen">

            <div class="col-span-1">
                    @include('layouts.nav')
            </div>

            @yield('content')
            @livewireScripts
            @stack('scripts')
        
        </div>

    </body>
</html>
