<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hydrogen Hub</title>

        <!-- Tailwind -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}"></link>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <!-- Jquery -->
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous">
        </script>
        <!-- Ion.RangeSlider -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

        @stack('styles')
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://kit.fontawesome.com/d7f253ad4b.js" crossorigin="anonymous"></script>
        @livewireStyles
    </head>

    <body class="bg-background font-sans">

        <div class="grid grid-cols-8 grid-rows-1">
            @auth()
            <div class="h-screen sticky top-0 col-span-1 sm:col-span-2 z-50">
                    @include('layouts.nav')
            </div>
            @endauth

            <div class="@auth col-span-7 sm:col-span-6 @endauth @guest col-span-8 sm:col-span-8 @endguest">
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
