<div class="flex flex-col max-w-full max-h-full">
    <div class="flex flex-none w-full justify-between">
        <h2 class="xxl:text-3xl font-bold">Portfolio</h2>
        <button class="text-sm xxl:text-2xl font-semibold text-gray-600 hover:text-gray-800 transaction duration-300"
                wire:click="openSelectionModal"> + Add graph
        </button>
    </div>

    <div class="flex flex-auto justify-between sm:items-center sm:flex-col text-center overflow-auto gap-10 pb-6">
    @foreach($chartData as $chart)
        <div class="sm:w-full max-h-40 flex flex-col items-center">
            <div class="relative flex flex-col sm:w-full" style="width: 24vw; height: 28vh;">
                <div class="absolute z-10 inset-0 opacity-0 hover:opacity-50 transaction duration-300 cursor-pointer bg-gray-900 rounded-lg flex-col" wire:click="openChartExpandedModal('{{ $chart['hydrogenType'] }}')">
                    <span class="text-white flex h-full items-center justify-center text-3xl font-semibold">Expand</span>
                </div>

                <canvas wire:ignore id="canvas-{{ $chart['hydrogenType'] }}" class="flex z-0"></canvas>
            </div>

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
    <script type>
        let ctxOverview = null;
        let chartOverview = null

        let colorsOverview = {
            "chartDemandColor": "",
            "chartTotalLoadColor": ""
        }

        createOverviews();

        function createOverviews(chartData=null) {
            if (!chartData) {
                chartData = @json($chartData);
            }

            if (chartData) {
                for(let k in chartData) {
                    setupOverview(chartData[k].hydrogenType);
                    createOverview(chartData[k]);
                }
            }
        }

        function setupOverview(hydrogenType) {
            ctxOverview = document.getElementById(`canvas-${hydrogenType}`).getContext("2d");

            colorsOverview["chartDemandColor"] = "#4CD35D";
            colorsOverview["chartTotalLoadColor"] = "#d3fdd8";

            if (hydrogenType === 'blue') {
                colorsOverview["chartDemandColor"] = "#003399";
                colorsOverview["chartTotalLoadColor"] = "#cbe4fd";
            }
            else if (hydrogenType === 'grey') {
                colorsOverview["chartDemandColor"] = "#909090";
                colorsOverview["chartTotalLoadColor"] = "#e8e8e8";
            }
            else if (hydrogenType === 'mix') {
                colorsOverview["chartDemandColor"] = "#CEB076";
                colorsOverview["chartTotalLoadColor"] = "#EDD3A1";
            }
            else if (hydrogenType === 'combined') {
                colorsOverview["chartDemandColor"] = "#FCA357";
                colorsOverview["chartTotalLoadColor"] = "#F4C9A4";
            }
        }

        function clearOverviews() {
            let chartData = @json($chartData);

            if (chartData) {
                for(let k in chartData) {
                    clearOverview(chartData[k].hydrogenType);
                }
            }
        }

        function clearOverview(hydrogenType) {
            if (chartOverview) {
                chartOverview.destroy();
            }

            ctxOverview = document.getElementById(`canvas-${hydrogenType}`).getContext("2d");

            for (let color in colorsOverview) {
                colorsOverview[color] = "#000000";
            }

            chartOverview = new Chart(ctxOverview, {
                type: 'bar',
                options: {
                    title: {
                        display: false,
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
                                    min: 0,
                                    max: 100
                                },
                            },
                            {
                                id: "bar-y-axis",
                                stacked: true,
                                display: false,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 100
                                },
                                type: 'linear'
                            }
                        ]
                    }
                }
            });
            ctxOverview = null;
        }

        function createOverview(chartData) {
            let chartDataOverview = {
                labels: chartData.labels,
                datasets: [
                    {
                        data: chartData.demand,
                        type: 'line',
                        label: 'Demand',
                        fill: true,
                        backgroundColor: "#00ff0000",
                        pointBackgroundColor: "#fff",
                        borderColor: colorsOverview["chartDemandColor"],
                        pointHoverBackgroundColor: colorsOverview["chartDemandColor"],
                        pointBorderColor: colorsOverview["chartDemandColor"],
                        pointHoverBorderColor: colorsOverview["chartDemandColor"],
                        borderCapStyle: 'butt',
                        borderJoinStyle: 'round',
                        lineTension: 0,
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 2,
                        pointRadius: 4,
                        pointHitRadius: 10
                    },
                    {
                        label: 'Total load',
                        backgroundColor: colorsOverview["chartTotalLoadColor"],
                        borderColor: colorsOverview["chartTotalLoadColor"],
                        yAxisID: "bar-y-axis",
                        data: chartData.totalLoad
                    },
                ]
            }

            chartOverview = new Chart(ctxOverview, {
                type: 'bar',
                data: chartDataOverview,
                options: {
                    onClick: chartClicked,
                    title: {
                        display: true,
                        text: `${chartData.hydrogenType.charAt(0).toUpperCase() + chartData.hydrogenType.slice(1)}`,
                    },
                    tooltips: {
                        mode: 'label'
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [
                            {
                                id: "bar-x-axis-inner",
                                stacked: true,
                                categoryPercentage: 1,
                                barPercentage: 0.8
                            },
                            {
                                id: "bar-x-axis-outer",
                                stacked: false,
                                display: false,
                                categoryPercentage: 1.0,
                                barPercentage: 1.0
                            }
                        ],
                        yAxes: [
                            {
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    min: chartData.min,
                                    max: chartData.max
                                },
                            },
                            {
                                id: "bar-y-axis",
                                stacked: true,
                                display: false,
                                ticks: {
                                    beginAtZero: true,
                                    min: chartData.min,
                                    max: chartData.max
                                },
                                type: 'linear',
                            }
                        ]
                    }
                }
            });
        }

        Livewire.on('chartDataOverviewsUpdated', function (chartData) {
            clearOverviews();
            createOverviews(chartData);
        });
    </script>
@endpush
