<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hydrogen Hub</title>

    <!-- Tailwind -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}"></link>

    <!-- Jquery -->
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous">
    </script>
    
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @livewireStyles
</head>
    <body class="bg-background font-sans">

        <div class="grid grid-cols-8 grid-rows-1 h-screen">

            <div class="col-span-1 sm:col-span-2">
                    @include('layouts.nav')
            </div>

            <div class="col-span-7 sm:col-span-6">
                    @yield('content')
                    @livewireScripts
                    @stack('scripts')
            </div>

        
        </div>

        <script>
                const overlay = document.querySelector('#settings')
                const selectBtn = document.querySelector('#settings-btn')
                const closeBtn = document.querySelector('#close-settings')

                const toggleSetting = () => {
                    overlay.classList.toggle('hidden')
                    overlay.classList.toggle('grid')
                }

                selectBtn.addEventListener('click', toggleSetting)
                closeBtn.addEventListener('click', toggleSetting)
        </script>

    </body>
</html>
