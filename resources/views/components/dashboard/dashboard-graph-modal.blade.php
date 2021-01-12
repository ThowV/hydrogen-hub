<div wire:keydown.esc="toggleModal()">
    <div class="z-40 relative w-full h-full text-gray-700">
        <div class="modal fixed top-0 left-0 h-full w-full grid grid-cols-8 grid-rows-6">
            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal()"></div>
            <div class="modal-container max-h-full max-w-full grid col-start-2 sm:col-start-3 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded-lg shadow-lg z-50">
                <div class="modal-content flex flex-col gap-5 w-full h-full p-8 sm:p-4 xxl:p-12 text-left">
                    <div class="flex flex-row w-full justify-between">
                        <h2 class="text-base xxl:text-3xl font-bold">Detailed {{$this->typeOfGraphInModal}} graph </h2>
                        <div class="">
                            <select wire:model="selectedTimeRange">
                            @foreach($this->timeRanges as $amount => $timeRange)
                                    <option value="{{$amount}}">{{$timeRange}}</option>
                            @endforeach
                            </select>
                            <div wire:click="toggleModal()" class="modal-close cursor-pointer h-full z-50">
                                <svg
                                    class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full h-full">
                        <canvas class="h-vh55 w-vw80" wire:key="detailed" wire:ignore.self id="canvas-detailed"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        var dataset = {
            labels: @json($this->labels),
            datasets: [
                    @foreach(collect($this->lineProperties[$this->typeOfGraphInModal])->except('callback') as $priceGraphLine)
                {
                    data: @json($priceGraphLine['data']),
                    type: 'LineWithLine',
                    label: '{{$priceGraphLine['label']}}',
                    fill: true,
                    @if($this->typeOfGraphInModal == "mix")
                    backgroundColor: '#676767',
                    @else
                    backgroundColor: '#00ff0000',
                    @endif
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
                    pointRadius: 2,
                    pointHitRadius: 10
                },
                @endforeach
            ],
        };
        var detailedChart = document.getElementById("canvas-detailed").getContext("2d");
        window.myLine = new Chart(detailedChart, {
            type: 'line',
            data: dataset,
            options: {
                onClick: dataPointClicked,
                title: {
                    display: true,
                    text: "Detailed  {{$this->typeOfGraphInModal}} graph"
                },
                tooltips: {
                    mode: 'label'
                },
                maintainAspectRatio: false,
                responsive: false,
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
                            min: {{$this->chartProperties[$this->typeOfGraphInModal]['limits']['min']}},
                            max: {{$this->chartProperties[$this->typeOfGraphInModal]['limits']['max']}}
                        },
                    }]
                }
            }
        });
    </script>
</div>
