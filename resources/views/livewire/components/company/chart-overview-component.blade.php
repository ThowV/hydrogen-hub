<div class="flex flex-col max-w-full max-h-full">
    <div class="flex flex-none w-full justify-between">
        <h2 class="xxl:text-3xl font-bold">Portfolio</h2>
        <button class="text-sm xxl:text-2xl font-semibold text-gray-600 hover:text-gray-800 transaction duration-300"
                wire:click="openSelectionModal"> + Add graph
        </button>
    </div>

    <div class="flex flex-auto justify-around sm:items-center sm:flex-col text-center">
    @foreach($chartData as $chart)
        <div class="w-1/4 sm:w-full max-h-40 flex flex-col items-center">
            <div class="relative flex flex-col sm:w-full" style="width: 24vw; height: 28vh;">
                <div class="absolute z-10 inset-0 opacity-0 hover:opacity-50 transaction duration-300 cursor-pointer bg-gray-900 rounded-lg flex-col" wire:click="openChartExpandedModal('{{ $chart['hydrogenType'] }}')">
                    <span class="text-white flex h-full items-center justify-center text-3xl font-semibold">Expand</span>
                </div>

                <canvas wire:ignore id="canvas-{{ $chart['hydrogenType'] }}" class="flex z-0"></canvas>
            </div>

            @if($chart['shortage'])
            <p class="flex flex-none pt-8 justify-center md:text-sm font-semibold gap-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                    <path id="Icon_material-error-outline" data-name="Icon material-error-outline" d="M11.1,14.7h1.8v1.8H11.1Zm0-7.2h1.8v5.4H11.1ZM11.991,3A9,9,0,1,0,21,12,9,9,0,0,0,11.991,3ZM12,19.2A7.2,7.2,0,1,1,19.2,12,7.2,7.2,0,0,1,12,19.2Z" fill="#f05959"/>
                </svg>
                {{ $chart['shortage'] }}
            </p>
            @endif
        </div>
    @endforeach
    </div>
</div>

<script type="javascript">
    @push('scripts_onload')
    let chartData = @json($chartData);

    for (const chart in chartData) {
        let chartDemandColor = "#4CD35D";
        let chartTotalLoadColor = "#d3fdd8";

        if (chartData[chart].hydrogenType === 'blue') {
            chartDemandColor = "#0099FF";
            chartTotalLoadColor = "#cbe4fd";
        }
        else if (chartData[chart].hydrogenType === 'grey') {
            chartDemandColor = "#909090";
            chartTotalLoadColor = "#e8e8e8";
        }

        let ctx = document.getElementById("canvas-" + chart).getContext("2d");

        let chartDataCJS = {
            labels: chartData[chart].labels,
            datasets: [
                {
                    data: chartData[chart].demand,
                    type: 'line',
                    label: 'Demand',
                    fill: true,
                    backgroundColor: "#00ff0000",
                    pointBackgroundColor: chartDemandColor,
                    borderColor: chartDemandColor,
                    pointHoverBackgroundColor: chartDemandColor,
                    pointBorderColor: chartDemandColor,
                    pointHoverBorderColor: chartDemandColor,
                    borderCapStyle: 'butt',
                    borderJoinStyle: 'round',
                    lineTension: 0,
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBorderWidth: 2,
                    pointRadius: 3,
                    pointHitRadius: 10
                },
                {
                    label: 'Total load',
                    backgroundColor: chartTotalLoadColor,
                    borderColor: chartTotalLoadColor,
                    yAxisID: "bar-y-axis",
                    data: chartData[chart].totalLoad
                },
            ]
        }

        window.ldc = new Chart(ctx, {
            type: 'bar',
            data: chartDataCJS,
            options: {
                title: {
                    display: true,
                    text: chart.charAt(0).toUpperCase() + chart.slice(1)
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
                    yAxes: [
                        {
                            stacked: false,
                            ticks: {
                                beginAtZero: true,
                                min: chartData[chart].min,
                                max: chartData[chart].max
                            },
                        },
                        {
                            id: "bar-y-axis",
                            stacked: true,
                            display: false,
                            ticks: {
                                beginAtZero: true,
                                min: chartData[chart].min,
                                max: chartData[chart].max
                            },
                            type: 'linear'
                        }
                    ]
                }
            }
        });
    }
    @endpush
</script>
