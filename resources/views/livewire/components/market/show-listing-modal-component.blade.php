<div class="z-40 w-full text-gray-700">
    @if ($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded-lg shadow-lg z-50 ">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content flex flex-col w-full h-full p-8 sm:p-4 xxl:p-12 text-left ">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-5 sm:pb-2">
                        <p class="text-xl xxl:text-4xl font-bold">{{ $trade->trade_type == "offer" ? "Buy" : "Sell" }} hydrogen</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer h-full z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    @if (!$confirmationStage)
                        <div class="flex justify-center font-bold pb-12 sm:pb-4 text-xl xxl:text-2xl">Overview</div>
                    @else
                        <div class="flex justify-center font-bold pb-12 sm:pb-4 text-xl xxl:text-2xl">Accept this listing?</div>
                    @endif

                    @if (!$confirmationStage)
                        <!--Body-->
                        <div class="flex flex-row w-full h-full sm:flex-col">

                            @if($trade->owner_id != auth()->id())
                            <div class="w-2/4 flex justify-center">
                                    <div class="relative flex flex-col sm:w-full" style="width: 28vw; height: 32vh;">
                                        <canvas wire:ignore id="canvas-impact" class="flex z-0"></canvas>
                                    </div>
                            </div>

                            <div class="w-2/4 sm:w-full h-full grid grid-cols-4 grid-rows-3 text-sm">
                            @else
                            <div class="w-full sm:w-full h-full grid grid-cols-4 grid-rows-3 text-sm">
                            @endif


                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Hydrogen type:</p>
                                    <div class="flex flex-row items-start">
                                        <svg class="fill-current text-type{{ ucfirst($trade->hydrogen_type) }}-500" height="24" width="24">
                                            <circle cx="10" cy="12" r="6" />
                                        </svg>
                                        <p class="sm:text-xs xxl:text-2xl"><b> {{ $trade->hydrogen_type }} </b></p>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="sm:text-xxs xxl:text-xl">Units per hour:</p>
                                    <p class="sm:text-xs xxl:text-2xl"><b> {{ $trade->units_per_hour }} </b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Duration:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> {{ $trade->end }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Mix CO2:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> {{ $trade->mix_co2 }}%</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Total volume:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> {{ number_format($trade->total_volume, 0, '.', ' ') }} units</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Price per unit:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> € {{ $trade->price_per_unit }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Trade type:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> {{ $trade->trade_type }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-3">
                                    <p class="text-sm sm:text-xxs xxl:text-xl">Expires at:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> {{ $trade->expires_at_readable }}</b></p>
                                </div>

                                <div class="flex flex-row gap-5 sm:gap-3 col-start-2 col-span-2 mx-auto">
                                    <p class="sm:text-xxs xxl:text-xl">Total value contract:</p>
                                    <p class="text-sm sm:text-xs xxl:text-2xl"><b> € {{ number_format($trade->total_price, 0, '.', ' ') }}</b></p>
                                </div>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="w-full h-24 flex justify-center items-center gap-10 text-red-600">
                            @if($trade->owner_id != auth()->id())
                                @if($tradeAble && !$trade->responder_id)
                                    <button
                                        class="bg-personal hover:bg-hovBlue border-2 border-personal hover:border-hovBlue text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                                        wire:click="toggleConfirmationStage">
                                        {{ $trade->trade_type == "offer" ? "Buy" : "Sell" }}
                                    </button>
                                @elseif(!$tradeAble)
                                        Not enough funds
                                @endif
                            @endif

                            <button wire:click="toggleModal" class="modal-close text-gray-600 hover:text-gray-900 transition duration-300 ease-in-out">Close</button>
                        </div>

                    @elseif($confirmationStage)
                        <div class="flex flex-row w-full h-full justify-center">
                            <div class="flex flex-col h-full justify-center gap-10">

                                <div class="flex flex-col gap-2 text-left">
                                    <p>Password for confirmation</p>
                                    <input
                                        class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1"
                                        wire:model="password" id="passwordInput" name="passwordInput" type="password" placeholder="******************"
                                    >
                                    @error('password') <p class="text-red-600 text-xs pt-4">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex gap-10 items-center w-full">
                                    <button
                                        class="bg-personal hover:bg-hovBlue border-2 border-personal hover:border-hovBlue text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                                        wire:click="makeTrade({{ $trade->id }})">
                                        Confirm
                                    </button>

                                    <button
                                        class="text-gray-600 hover:text-gray-900 transition duration-300 ease-in-out"
                                        wire:click="toggleConfirmationStage">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        Livewire.on('listingOpened', function (chartData) {
            let ctx = document.getElementById("canvas-impact").getContext("2d");

            let chartDemandColor = "#317939";
            let chartNewTotalLoadColor = "#75d88c";
            let chartLoadLeftColor = "#d3fdd8";
            let chartLoadRemovedColor = "#F0CFB3";
            let chartLoadAddedColor = "#7DB0ED";

            if (chartData.hydrogenType === 'blue') {
                chartDemandColor = "#003399";
                chartLoadLeftColor = "#cbe4fd";
                chartNewTotalLoadColor = "#5ea5f8";
            }
            else if (chartData.hydrogenType === 'grey') {
                chartDemandColor = "#2F2F2F";
                chartLoadLeftColor = "#e8e8e8";
                chartNewTotalLoadColor = "#999999";
            }

            let chartDataImpact = {
                labels: chartData.labels,
                datasets: [
                    {
                        data: chartData.newTotalLoad,
                        type: 'line',
                        label: 'New total load',
                        fill: true,
                        backgroundColor: "#00ff0000",
                        pointBackgroundColor: "#fff",
                        borderColor: chartNewTotalLoadColor,
                        pointHoverBackgroundColor: chartNewTotalLoadColor,
                        pointBorderColor: chartNewTotalLoadColor,
                        pointHoverBorderColor: chartNewTotalLoadColor,
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
                        data: chartData.demand,
                        type: 'LineWithLine',
                        label: 'Demand',
                        fill: true,
                        backgroundColor: "#00ff0000",
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
                        label: 'Load left',
                        backgroundColor: chartLoadLeftColor,
                        borderColor: chartLoadLeftColor,
                        yAxisID: "bar-y-axis",
                        data: chartData.loadLeft
                    },
                    {
                        label: 'Load removed',
                        backgroundColor: chartLoadRemovedColor,
                        borderColor: chartLoadRemovedColor,
                        yAxisID: "bar-y-axis",
                        data: chartData.loadRemoved
                    },
                    {
                        label: 'Load added',
                        backgroundColor: chartLoadAddedColor,
                        borderColor: chartLoadAddedColor,
                        yAxisID: "bar-y-axis",
                        data: chartData.loadAdded
                    },
                ]
            }

            window.ldc = new Chart(ctx, {
                type: 'bar',
                data: chartDataImpact,
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
                                type: 'linear'
                            }
                        ]
                    }
                }
            });
        });
    </script>
@endpush
