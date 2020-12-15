<div class="flex flex-col max-w-full h-full">
    <div class="flex flex-none w-full justify-between">
        <h2 class="text-base xxl:text-3xl font-bold">Portfolio</h2>
        <button class="text-sm xxl:text-2xl bg-none font-semibold text-gray-600 hover:text-gray-800 transaction duration-300"
                wire:click="toggleEmployeeCreationModal"> + Add graph
        </button>
    </div>

    <div class="h-full flex flex-auto sm:flex-col text-center">
    @foreach($chartData as $chart)
        <div class="flex flex-col w-1/3 sm:w-full h-full">
            <canvas id="canvas-{{ $chart['hydrogen_type'] }}" class="flex"></canvas>
            @if($chart['shortage'])
            <p class="flex flex-none pt-8 justify-center text-xs gap-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path id="Icon_material-error-outline" data-name="Icon material-error-outline" d="M11.1,14.7h1.8v1.8H11.1Zm0-7.2h1.8v5.4H11.1ZM11.991,3A9,9,0,1,0,21,12,9,9,0,0,0,11.991,3ZM12,19.2A7.2,7.2,0,1,1,19.2,12,7.2,7.2,0,0,1,12,19.2Z" transform="translate(-3 -3)" fill="#f05959"/>
                </svg>
                {{ $chart['shortage'] }}
            </p>
            @endif
        </div>
    @endforeach
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
            crossorigin="anonymous"></script>

    <script>
        @foreach($chartData as $chart)
            var data_{{ $chart['hydrogen_type'] }} = {
                labels: @json($labels),
                datasets: [
                    {
                        data: @json($chart['demands']),
                        type: 'line',
                        label: 'Demand',
                        fill: true,
                        backgroundColor: "#00ff0000",
                        borderColor: "#003399",
                        borderCapStyle: 'butt',
                        borderJoinStyle: 'round',
                        lineTension: 0,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#003399",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#003399",
                        pointHoverBorderColor: "#003399",
                        pointHoverBorderWidth: 2,
                        pointRadius: 4,
                        pointHitRadius: 10
                    },
                    {
                        label: 'Total load',
                        backgroundColor: "#CBE4FD",
                        borderColor: "#CBE4FD",
                        yAxisID: "bar-y-axis",
                        data: @json($chart['totalLoads'])
                    },
                ],
            };
        @endforeach

        window.onload = function () {
            @foreach($chartData as $chart)
                var ctx = document.getElementById("canvas-{{ $chart['hydrogen_type'] }}").getContext("2d");
                window.myBar = new Chart(ctx, {
                    type: 'bar',
                    data: data_{{ $chart['hydrogen_type'] }},
                    options: {
                        title: {
                            display: true,
                            text: "Chart {{ $chart['hydrogen_type'] }}"
                        },
                        tooltips: {
                            mode: 'label'
                        },
                        responsive: true,
                        scales: {
                            xAxes: [{
                                stacked: true,
                                categoryPercentage: 1.0,
                                barPercentage: 1.0
                            }],
                            yAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    min: {{ $chart['min'] }},
                                    max: {{ $chart['max'] }}
                                },
                            }, {
                                id: "bar-y-axis",
                                stacked: true,
                                display: false, //optional
                                ticks: {
                                    beginAtZero: true,
                                    min: {{ $chart['min'] }},
                                    max: {{ $chart['max'] }}
                                },
                                type: 'linear'
                            }]
                        }
                    }
                });
            @endforeach
        };
    </script>
@endpush
