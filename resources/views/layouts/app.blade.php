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
        <!-- ChartJS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
                integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
                crossorigin="anonymous"></script>

        <!-- Fontawesome -->
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
            //Add vertical line to hover effect
            Chart.defaults.LineWithLine = Chart.defaults.line;
            Chart.controllers.LineWithLine = Chart.controllers.line.extend({
                draw: function (ease) {
                    Chart.controllers.line.prototype.draw.call(this, ease);
                    if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
                        var activePoint = this.chart.tooltip._active[0],
                            ctx = this.chart.ctx,
                            x = activePoint.tooltipPosition().x,
                            topY = this.chart.legend.bottom,
                            bottomY = this.chart.chartArea.bottom;
                        // draw line
                        ctx.save();
                        ctx.beginPath();
                        ctx.moveTo(x, topY);
                        ctx.lineTo(x, bottomY);
                        ctx.lineWidth = 2;
                        //HOVER VERTICAL LINE COLOR
                        ctx.strokeStyle = '#07C';
                        ctx.stroke();
                        ctx.restore();
                    }
                }
            });
        </script>

    </body>
</html>
