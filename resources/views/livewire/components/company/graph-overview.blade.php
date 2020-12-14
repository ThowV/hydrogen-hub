<div>
    <canvas id="canvas"></canvas>
    @if($shortage)
        <p>{{ $shortage }}</p>
    @endif
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
            crossorigin="anonymous"></script>

    <script>
        var barChartData = {
            labels: @json($labels),
            datasets: [
                {
                    data: @json($demands),
                    type: 'line',
                    label: 'Demand',
                    fill: true,
                    backgroundColor: "#00ff0000",
                    borderColor: "#003399",
                    borderCapStyle: 'butt',
                    borderJoinStyle: 'round',
                    lineTension: 0.1,
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
                    data: @json($totalLoads)
                },
            ],
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
                            categoryPercentage: 1.0,
                            barPercentage: 1.0
                        }],
                        yAxes: [{
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                min: {{ $min }},
                                max: {{ $max }}
                            },
                        }, {
                            id: "bar-y-axis",
                            stacked: true,
                            display: false, //optional
                            ticks: {
                                beginAtZero: true,
                                min: {{ $min }},
                                max: {{ $max }}
                            },
                            type: 'linear'
                        }]
                    }
                }
            });
        };
    </script>
@endpush
