<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-1 col-span-7 sm:col-span-6 mx-10 my-24 xxl:mx-20 row-span-6 bg-white rounded-lg shadow-lg z-50">
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

                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50 transform translate-x-4 -translate-y-4">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <div class="flex flex-auto">
                        <div>
                            <div class="w-full sm:w-full max-h-80 flex flex-col items-center">
                                <div class="relative flex flex-col sm:w-full" style="width: 48vw; height: 56vh;">
                                    <canvas wire:ignore id="canvas-expanded" class="flex z-0"></canvas>
                                </div>
                                @if($chart && $chart['shortage'])
                                    <p class="flex flex-none pt-8 justify-center text-xs gap-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                            <path id="Icon_material-error-outline" data-name="Icon material-error-outline" d="M11.1,14.7h1.8v1.8H11.1Zm0-7.2h1.8v5.4H11.1ZM11.991,3A9,9,0,1,0,21,12,9,9,0,0,0,11.991,3ZM12,19.2A7.2,7.2,0,1,1,19.2,12,7.2,7.2,0,0,1,12,19.2Z" transform="translate(-3 -3)" fill="#f05959"/>
                                        </svg>
                                        {{ $chart['shortage'] }}
                                    </p>
                                @endif
                            </div>
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
    @endif
</div>

@push('scripts')
    <script>
        let ctxExpanded = null;
        let chartExpanded = null

        let colorsExpanded = {
            "chartDemandColor": "",
            "chartProduceColor": "",
            "chartBoughtColor": "",
            "chartStoreColor": "",
            "chartSoldColor": "",
            "chartTotalLoadColor": '',
        }

        function setupExpanded(hydrogenType) {
            ctxExpanded = document.getElementById("canvas-expanded").getContext("2d");

            colorsExpanded["chartDemandColor"] = "#317939";
            colorsExpanded['chartProduceColor'] = "#BEBEBE";
            colorsExpanded['chartBoughtColor'] = "#CBE4FD";
            colorsExpanded["chartStoreColor"] = "#7DB0ED"
            colorsExpanded["chartSoldColor"] = "#F0CFB3";
            colorsExpanded["chartTotalLoadColor"] = "#5CE06A"

            if (hydrogenType === 'blue') {
                colorsExpanded["chartDemandColor"] = "#003399";
                colorsExpanded["chartTotalLoadColor"] = "#0099ff";
            }
            else if (hydrogenType === 'grey') {
                colorsExpanded["chartDemandColor"] = "#2F2F2F";
                colorsExpanded["chartTotalLoadColor"] = "#796758";
            }
        }

        function createExpanded(chartData) {
            let chartDataExpanded = {
                labels: chartData.labels,

                datasets: [
                    {
                        data: chartData.demand,
                        type: 'line',
                        label: 'Demand',
                        fill: true,
                        backgroundColor: "transparent",
                        pointBackgroundColor: "#fff",
                        borderColor: colorsExpanded['chartDemandColor'],
                        pointHoverBackgroundColor: colorsExpanded['chartDemandColor'],
                        pointBorderColor: colorsExpanded['chartDemandColor'],
                        pointHoverBorderColor: colorsExpanded['chartDemandColor'],
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
                        data: chartData.totalLoad,
                        type: 'line',
                        label: 'Total load',
                        fill: true,
                        backgroundColor: "transparent",
                        pointBackgroundColor: "#fff",
                        borderColor: colorsExpanded['chartTotalLoadColor'],
                        pointHoverBackgroundColor: colorsExpanded['chartTotalLoadColor'],
                        pointBorderColor: colorsExpanded['chartTotalLoadColor'],
                        pointHoverBorderColor: colorsExpanded['chartTotalLoadColor'],
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
                        backgroundColor: colorsExpanded['chartProduceColor'],
                        xAxisID: "bar-x-axis-inner",
                        yAxisID: "bar-y-axis",
                        data: chartData.produce
                    },
                    {
                        label: 'Bought',
                        backgroundColor: colorsExpanded['chartBoughtColor'],
                        xAxisID: "bar-x-axis-inner",
                        yAxisID: "bar-y-axis",
                        data: chartData.bought
                    },
                    {
                        label: 'Store',
                        backgroundColor: colorsExpanded['chartStoreColor'],
                        xAxisID: "bar-x-axis-inner",
                        yAxisID: "bar-y-axis",
                        data: chartData.store
                    },
                    {
                        label: 'Sold',
                        backgroundColor: colorsExpanded['chartSoldColor'],
                        xAxisID: "bar-x-axis-inner",
                        yAxisID: "bar-y-axis",
                        data: chartData.sold
                    }
                ]
            };

            chartExpanded = new Chart(ctxExpanded, {
                type: 'bar',
                data: chartDataExpanded,
                options: {
                    onClick: chartClicked,
                    title: {
                        display: true,
                        text: `${chartData.hydrogenType.charAt(0).toUpperCase() + chartData.hydrogenType.slice(1)} hydrogen`,
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

        function clearExpanded() {
            if (chartExpanded) {
                chartExpanded.destroy();
            }

            ctxExpanded = document.getElementById("canvas-expanded").getContext("2d");

            for (let color in colorsExpanded) {
                colorsExpanded[color] = "#000000";
            }

            chartExpanded = new Chart(ctxExpanded, {
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
                                type: 'linear',
                            }
                        ]
                    }
                }
            });

            ctxExpanded = null;
        }

        function chartClicked(event, array) {
            if (Array.isArray(array) && array.length > 0) {
                index_x = array[0]._index;
                Livewire.emit('chartClicked', index_x);

            }
        }

        Livewire.on('chartExpandedOpened', function (chartData) {
            setupExpanded(chartData.hydrogenType);
            createExpanded(chartData);
        });

        Livewire.on('chartExpandedDataUpdated', function (chartData) {
            clearExpanded();
            setupExpanded(chartData.hydrogenType);
            createExpanded(chartData);
        });
    </script>
@endpush
