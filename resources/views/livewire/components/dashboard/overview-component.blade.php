<div class="min-h-full flex flex-row">
    <div class="w-1/3">
        <canvas wire:ignore id="canvas-price"></canvas>
    </div>
    <div class="w-1/3">
        <canvas wire:ignore id="canvas-volumes"></canvas>
    </div>
    <div class="w-1/3">
        <canvas wire:ignore id="canvas-mixH2"></canvas>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
            crossorigin="anonymous"></script>

    <script>
        var dataset = {
            labels: @json($priceGraphLabels),
            datasets: [
                    @foreach($lineProperties as $priceGraphLine)
                {
                    data: @json($priceGraphLine['data']),
                    type: 'line',
                    label: '{{$priceGraphLine['label']}}',
                    fill: true,
                    backgroundColor: '#00ff0000',
                    borderColor: '{{$priceGraphLine['borderColor']}}',
                    borderCapStyle: 'butt',
                    borderJoinStyle: 'round',
                    lineTension: 0,
                    pointBackgroundColor: '{{$priceGraphLine['pointBackgroundColor']}}',
                    pointBorderColor: '{{$priceGraphLine['pointBorderColor']}}',
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '{{$priceGraphLine['pointHoverBackgroundColor']}}',
                    pointHoverBorderColor: '{{$priceGraphLine['pointHoverBorderColor']}}',
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 10
                },
                @endforeach
            ],
        };
        var dataset2 = {
            labels: @json($priceGraphLabels),
            datasets: [
                    @foreach($lineProperties as $priceGraphLine)
                {
                    data: @json($priceGraphLine['data']),
                    type: 'line',
                    label: '{{$priceGraphLine['label']}}',
                    fill: true,
                    backgroundColor: '#00ff0000',
                    borderColor: '{{$priceGraphLine['borderColor']}}',
                    borderCapStyle: 'butt',
                    borderJoinStyle: 'round',
                    lineTension: 0,
                    pointBackgroundColor: '{{$priceGraphLine['pointBackgroundColor']}}',
                    pointBorderColor: '{{$priceGraphLine['pointBorderColor']}}',
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '{{$priceGraphLine['pointHoverBackgroundColor']}}',
                    pointHoverBorderColor: '{{$priceGraphLine['pointHoverBorderColor']}}',
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 10
                },
                @endforeach
            ],
        };
        var dataset3 = {
            labels: @json($priceGraphLabels),
            datasets: [
                {
                    data: @json($priceGraphLine['data']),
                    type: 'line',
                    label: '{{$priceGraphLine['label']}}',
                    fill: true,
                    backgroundColor: '#00ff0000',
                    borderColor: '{{$priceGraphLine['borderColor']}}',
                    borderCapStyle: 'butt',
                    borderJoinStyle: 'round',
                    lineTension: 0,
                    pointBackgroundColor: '{{$priceGraphLine['pointBackgroundColor']}}',
                    pointBorderColor: '{{$priceGraphLine['pointBorderColor']}}',
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '{{$priceGraphLine['pointHoverBackgroundColor']}}',
                    pointHoverBorderColor: '{{$priceGraphLine['pointHoverBorderColor']}}',
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 10
                },
            ],
        };

        window.onload = function () {
            var ctx = document.getElementById("canvas-price").getContext("2d");
            window.myLine = new Chart(ctx, {
                type: 'line',
                data: dataset,
                options: {
                    title: {
                        display: true,
                        text: "Price"
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
                                min: {{$chartProperties['limits']['min']}},
                                max: {{$chartProperties['limits']['max']}}
                            },
                        }]
                    }
                }
            });

            var ctx2 = document.getElementById("canvas-volumes").getContext("2d");
            window.myLine2 = new Chart(ctx2, {
                type: 'line',
                data: dataset2,
                options: {
                    title: {
                        display: true,
                        text: "Volumes"
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
                                min: {{$chartProperties['limits']['min']}},
                                max: {{$chartProperties['limits']['max']}}
                            },
                        }]
                    }
                }
            });

            var ctx3 = document.getElementById("canvas-mixH2").getContext("2d");
            window.myLine3 = new Chart(ctx3, {
                type: 'line',
                data: dataset3,
                options: {
                    title: {
                        display: true,
                        text: "mixH2"
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
                                min: {{$chartProperties['limits']['min']}},
                                max: {{$chartProperties['limits']['max']}}
                            },
                        }]
                    }
                }
            });
        };
    </script>
    <script>

    </script>
@endpush
