@extends('layouts.app')

@section('content')
    <div class="flex w-full h-full flex-col">
        <!--Trade info modal-->
    @livewire('components.company.trade-and-listing-info-modal-component')

    <!--Header-->
        <div class="w-full h-24 grid grid-col-2 grid-rows-2">
            <div class="col-start-1 flex flex-row items-baseline py-8 xxl:py-10">
                <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Company portfolio</h1>
                <h2 class="font-bold text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
            </div>
            <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
                <h3 class="font-bold text-xs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
            </div>
        </div>

        <!--Content-->
        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="background-white">
                <canvas id="canvas"></canvas>
            </div>
        </div>
        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex flex-row flex-nowrap min-h-full sm:flex-col">
                <div class="rounded-lg px-10 mr-4 w-3/6 sm:w-full sm:mr-0 md:w-2/4 bg-white text-gray-700">
                    @livewire('components.company.trades-component')
                </div>

                <div class="rounded-lg px-10 ml-4 w-2/6 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white text-gray-700">
                    @livewire('components.company.offers-requests-component')
                </div>

                <div class="rounded-lg px-10 ml-4 w-1/6 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white text-gray-700">
                    @livewire('components.company.financials-component')
                </div>
            </div>
        </div>
    </div>
@endsection()


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
            crossorigin="anonymous"></script>

    <script>
        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [
                // {
                //     data: [
                //         50, 30, 60, 70, 80, 90, 95, 70, 90, 20, 60, 95
                //     ],
                //     type: 'line',
                //     label: 'This Year',
                //     fill: false,
                //     backgroundColor: "#fff",
                //     borderColor: "#70cbf4",
                //     borderCapStyle: 'butt',
                //     borderDash: [],
                //     borderDashOffset: 0.0,
                //     borderJoinStyle: 'miter',
                //     lineTension: 0.3,
                //     pointBackgroundColor: "#fff",
                //     pointBorderColor: "#70cbf4",
                //     pointBorderWidth: 1,
                //     pointHoverRadius: 5,
                //     pointHoverBackgroundColor: "#70cbf4",
                //     pointHoverBorderColor: "#70cbf4",
                //     pointHoverBorderWidth: 2,
                //     pointRadius: 4,
                //     pointHitRadius: 10
                // }, {
                //     data: [
                //         25, 40, 30, 70, 60, 50, 40, 70, 40, 80, 30, 90
                //     ],
                //     type: 'line',
                //     label: 'Last Year',
                //     fill: false,
                //     backgroundColor: "#fff",
                //     borderColor: "#000",
                //     borderCapStyle: 'butt',
                //     borderDash: [],
                //     borderDashOffset: 0.0,
                //     borderJoinStyle: 'miter',
                //     lineTension: 0.3,
                //     pointBackgroundColor: "#fff",
                //     pointBorderColor: "#70cbf4",
                //     pointBorderWidth: 1,
                //     pointHoverRadius: 5,
                //     pointHoverBackgroundColor: "#70cbf4",
                //     pointHoverBorderColor: "#70cbf4",
                //     pointHoverBorderWidth: 2,
                //     pointRadius: 4,
                //     pointHitRadius: 10
                // },
                {
                    label: 'Promoters',
                    backgroundColor: "#aad700",
                    yAxisID: "bar-y-axis",
                    data: [
                        1,2,3,4,5,6,7
                    ]
                },
                {
                    label: 'Passives',
                    backgroundColor: "#ffe100",
                    yAxisID: "bar-y-axis",
                    data: [
                        20, 21, 24, 25, 26, 17, 28, 19, 20, 11, 22, 33
                    ]
                },
                // {
                //     label: 'Detractors',
                //     backgroundColor: "#ef0000",
                //     yAxisID: "bar-y-axis",
                //     data: [
                //         30, 35, 24, 13, 26, 25, 13, 31, 29, 37, 25, 13
                //     ]
                // }
            ]
        };

        window.onload = function () {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    title: {
                        display: true,
                        text: "Chart.js Bar Chart - Stacked"
                    },
                    tooltips: {
                        mode: 'label'
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                max: 100
                            }
                        }, {
                            id: "bar-y-axis",
                            stacked: true,
                            display: false, //optional
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                max: 100
                            },
                            type: 'linear'
                        }]
                    }
                }
            });
        };
    </script>
@endpush
