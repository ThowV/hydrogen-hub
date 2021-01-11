<div class="z-40 w-full text-gray-700" style="display: {{ $isOpen ? 'block' : 'none' }}">
    <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

        <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

        <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 mb-10 xxl:mx-20 row-span-5 bg-white rounded-lg shadow-lg z-50">
            <div class="modal-content flex flex-auto flex-col w-full h-full px-12 pt-12 sm:p-4 xxl:p-16 text-left">
                <!--Title-->
                <div class="flex flex-none justify-between items-center pb-2">
                    <div class="flex">
                        <svg class="fill-current text-type{{ ucfirst($chartType) }}-500"
                            height="24" width="24">
                            <circle cx="10" cy="12" r="6"/>
                        </svg> 
                        <p class="text-lg font-bold">{{ ucfirst($chartType) }} hydrogen</p>
                    </div>

                    <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                <div class="flex flex-auto">
                    <div>
                        @foreach($chartData as $chart)
                            <div class="w-full sm:w-full max-h-80 flex flex-col items-center" style="display: {{ $chartType == $chart['hydrogenType'] ? 'block' : 'none' }}">
                                <div class="relative flex flex-col sm:w-full" style="width: 48vw; height: 56vh;">
                                    <canvas wire:ignore id="canvasExpanded-{{ $chart['hydrogenType'] }}" class="flex z-0"></canvas>
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

                    <div class="h-full w-full">
                        @livewire('components.company.chart-expanded-info-component')
                    </div>
                </div>
            </div>


            <!--Footer-->
            <div class="flex flex-none justify-center pb-4">
                <button
                    class="modal-close my-auto bg-white border-2 hover:bg-gray-400 hover:border-gray-400 text-gray-600 hover:text-white text-xs xxl:text-2xl py-1 px-6 xxl:py-2 xxl:px-8 rounded-lg transition duration-200 ease-in-out"
                    wire:click="toggleModal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script type="javascript">
    @push('scripts_onload')
    // Create charts
    let chartDataExpanded = @json($chartData);

    for (const chart in chartDataExpanded) {
        let chartDemandColor = "#4CD35D";
        let chartProduceColor = "#BEBEBE";
        let chartBoughtColor = "#CBE4FD";
        let chartStoreColor = "#7DB0ED"
        let chartSoldColor = "#F0CFB3";
        let chartTotalLoadColor = "#d3fdd8"

        if (chartDataExpanded[chart].hydrogenType == 'blue') {
            chartDemandColor = "#003399";
            chartTotalLoadColor = "#cbe4fd";
        }
        else if (chartDataExpanded[chart].hydrogenType == 'grey') {
            chartDemandColor = "#909090";
            chartTotalLoadColor = "#e8e8e8";
        }

        let ctx = document.getElementById("canvasExpanded-" + chart).getContext("2d");

        let chartDataExpandedCJS = {
            labels: chartDataExpanded[chart].labels,
            datasets: [
                {
                    data: chartDataExpanded[chart].demand,
                    type: 'line',
                    label: 'Demand',
                    fill: true,
                    backgroundColor: "transparent",
                    pointBackgroundColor: "#fff",
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
                    pointRadius: 4,
                    pointHitRadius: 10
                },
                {
                    data: chartDataExpanded[chart].totalLoad,
                    type: 'line',
                    label: 'Total load',
                    fill: true,
                    backgroundColor: "transparent",
                    pointBackgroundColor: "#fff",
                    borderColor: chartTotalLoadColor,
                    pointHoverBackgroundColor: chartTotalLoadColor,
                    pointBorderColor: chartTotalLoadColor,
                    pointHoverBorderColor: chartTotalLoadColor,
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
                    label: 'Produce',
                    backgroundColor: chartProduceColor,
                    xAxisID: "bar-x-axis-inner",
                    yAxisID: "bar-y-axis",
                    data: chartDataExpanded[chart].produce
                },
                {
                    label: 'Bought',
                    backgroundColor: chartBoughtColor,
                    xAxisID: "bar-x-axis-inner",
                    yAxisID: "bar-y-axis",
                    data: chartDataExpanded[chart].bought
                },
                {
                    label: 'Store',
                    backgroundColor: chartStoreColor,
                    xAxisID: "bar-x-axis-inner",
                    yAxisID: "bar-y-axis",
                    data: chartDataExpanded[chart].store
                },
                {
                    label: 'Sold',
                    backgroundColor: chartSoldColor,
                    xAxisID: "bar-x-axis-inner",
                    yAxisID: "bar-y-axis",
                    data: chartDataExpanded[chart].sold
                }
            ]
        }

        window.ldc = new Chart(ctx, {
            type: 'bar',
            data: chartDataExpandedCJS,
            options: {
                onClick: chartClicked,
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
                                min: chartDataExpanded[chart].min,
                                max: chartDataExpanded[chart].max
                            },
                        },
                        {
                            id: "bar-y-axis",
                            stacked: true,
                            display: false,
                            ticks: {
                                beginAtZero: true,
                                min: chartDataExpanded[chart].min,
                                max: chartDataExpanded[chart].max
                            },
                            type: 'linear',
                        }
                    ]
                }
            }
        });
    }

    function chartClicked(event, array) {
        if (Array.isArray(array) && array.length > 0) {
            index_x = array[0]._index;
            Livewire.emit('chartClicked', index_x);

        }
    }
    @endpush
</script>
