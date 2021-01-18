<div class="w-full">
    <div class="">
        <h2 class="xxl:text-3xl font-bold pb-6">Hydrogen Hub overview</h2>
    </div>
    <div class="min-h-full flex justify-between">
        @if($modalIsOpen)
            <x-dashboard.dashboard-graph-modal></x-dashboard.dashboard-graph-modal>
        @endif
        @if($open['prices'])
            <div class="{{$colspan}} relative flex flex-col sm:w-full" style="width: 24vw; height: 28vh;">
                <div class="absolute z-10 inset-0 opacity-0 hover:opacity-50 transaction duration-300 cursor-pointer bg-gray-900 rounded-lg flex-col" wire:click="openDetailedGraphModal('prices')">
                    <span class="text-white flex h-full items-center justify-center text-3xl font-semibold">Expand</span>
                </div>

                <canvas wire:key="prices" wire:click="openDetailedGraphModal('prices')" wire:ignore.self
                        id="canvas-price"></canvas>
            </div>
        @endif
        @if($open['volumes'])
            <div class="{{$colspan}} relative flex flex-col sm:w-full" style="width: 24vw; height: 28vh;">
                <div class="absolute z-10 inset-0 opacity-0 hover:opacity-50 transaction duration-300 cursor-pointer bg-gray-900 rounded-lg flex-col" wire:click="openDetailedGraphModal('volumes')">
                    <span class="text-white flex h-full items-center justify-center text-3xl font-semibold">Expand</span>
                </div>

                <canvas wire:key="volumes" wire:click="openDetailedGraphModal('volumes')" wire:ignore.self
                        id="canvas-volumes"></canvas>
            </div>
        @endif
        @if($open['mix'])
            <div class="{{$colspan}} relative flex flex-col sm:w-full" style="width: 24vw; height: 28vh;">
                <div class="absolute z-10 inset-0 opacity-0 hover:opacity-50 transaction duration-300 cursor-pointer bg-gray-900 rounded-lg flex-col"  wire:click="openDetailedGraphModal('mix')">
                    <span class="text-white flex h-full items-center justify-center text-3xl font-semibold">Expand</span>
                </div>

                <canvas wire:key="mix" wire:click="openDetailedGraphModal('mix')" wire:ignore.self
                        id="canvas-mix"></canvas>
            </div>
        @endif
        @if($open['mix'])
            <div class="hidden relative flex flex-col sm:w-full" style="width: 24vw; height: 28vh;">
                <div class="absolute z-10 inset-0 opacity-0 hover:opacity-50 transaction duration-300 cursor-pointer bg-gray-900 rounded-lg flex-col" wire:click="openDetailedGraphModal('mix')">
                    <span class="text-white flex h-full items-center justify-center text-3xl font-semibold">Expand</span>
                </div>

                <canvas wire:key="mix" wire:click="openDetailedGraphModal('mix')" wire:ignore.self
                        id="canvas-mix"></canvas>
            </div>
        @endif

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
        integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
        crossorigin="anonymous"></script>
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
                ctx.lineWidth = 1;
                //HOVER VERTICAL LINE COLOR
                ctx.strokeStyle = '#07C';
                ctx.stroke();
                ctx.restore();
            }
        }
    });

    @if($open['prices'])
    var dataset = {
        labels: @json($labels),
        datasets: [
                @foreach(collect($lineProperties['prices'])->except('callback') as $priceGraphLine)
            {
                data: @json($priceGraphLine['data']),
                type: 'LineWithLine',
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
                pointRadius: 3,
                pointHitRadius: 10
            },
            @endforeach
        ],
    };
    var ctx = document.getElementById("canvas-price").getContext("2d");
    window.myLine = new Chart(ctx, {
        type: 'line',
        data: dataset,
        options: {
            title: {
                display: true,
                text: "Average price"
            },
            tooltips: {
                mode: 'label'
            },
            responsive: true,
            maintainAspectRatio: false,
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
                        min: {{$chartProperties['prices']['limits']['min']}},
                        max: {{$chartProperties['prices']['limits']['max']}}
                    },
                }]
            }
        }
    });

    @endif
    @if($open['volumes'])

    var dataset2 = {
        labels: @json($labels),
        datasets: [
                @foreach(collect($lineProperties['volumes'])->except('callback') as $priceGraphLine)
            {
                data: @json($priceGraphLine['data']),
                type: 'LineWithLine',
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
                pointRadius: 3,
                pointHitRadius: 10
            },
            @endforeach
        ],
    };
    var ctx2 = document.getElementById("canvas-volumes").getContext("2d");
    window.myLine2 = new Chart(ctx2, {
        type: 'line',
        data: dataset2,
        options: {
            title: {
                display: true,
                text: "Average Volumes"
            },
            tooltips: {
                mode: 'label'
            },
            responsive: true,
            maintainAspectRatio: false,
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
                        min: {{$chartProperties['volumes']['limits']['min']}},
                        max: {{$chartProperties['volumes']['limits']['max']}}
                    },
                }]
            }
        }
    });

    @endif
    @if($open['mix'])

    var dataset3 = {
        labels: @json($labels),
        datasets: [
            {
                data: @json($lineProperties['mix']['grey']['data']),
                type: 'LineWithLine',
                label: '{{$lineProperties['mix']['grey']['label']}}',
                fill: true,
                backgroundColor: '#00ff0000',
                borderColor: '#676767',
                borderCapStyle: 'butt',
                borderJoinStyle: 'round',
                lineTension: 0,
                pointBackgroundColor: '{{$lineProperties['mix']['grey']['pointBackgroundColor']}}',
                pointBorderColor: '{{$lineProperties['mix']['grey']['pointBorderColor']}}',
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '{{$lineProperties['mix']['grey']['pointHoverBackgroundColor']}}',
                pointHoverBorderColor: '{{$lineProperties['mix']['grey']['pointHoverBorderColor']}}',
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10
            },
        ],
    };
    var ctx3 = document.getElementById("canvas-mix").getContext("2d");
    window.myLine3 = new Chart(ctx3, {
        type: 'line',
        data: dataset3,
        options: {
            title: {
                display: true,
                text: "Average mix CO2"
            },
            tooltips: {
                mode: 'label'
            },
            responsive: true,
            maintainAspectRatio: false,
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
                        min: {{$chartProperties['mix']['limits']['min']}},
                        max: {{$chartProperties['mix']['limits']['max']}}
                    },
                }]
            }
        }
    });
    @endif

    function dataPointClicked(event, data) {
        $(document).ready(function () {
            if (Array.isArray(data) && data.length > 0) {
                Livewire.emit('getDetailedDataForDay', data[0]._index)
            }
        });
    }
</script>
