<div>
    @foreach($chartData as $chart)
        <canvas id="canvas-{{ $chart['hydrogen_type'] }}"></canvas>
        @if($chart['shortage'])
            <p>{{ $chart['shortage'] }}</p>
        @endif
    @endforeach
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
