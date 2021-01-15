<div class="z-40 text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid row-start-1 col-span-7 row-span-6 md:mt-8 mx-10 my-24 md:my-12 xxl:mx-20 bg-white rounded-lg shadow-lg z-50">
                <div class="modal-content flex flex-col p-12 sm:p-4 xxl:p-16 text-left">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-5 sm:pb-2">
                        <p class="text-xl xxl:text-4xl font-bold">Create listing</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    @if ($confirmationStage)
                        <div class="flex justify-center font-bold pb-4 sm:pb-4 text-xl xxl:text-2xl">Create this listing?</div>
                    @endif

                    <!--Body-->
                    @if (!$confirmationStage)
                        <div class="labels flex justify-between flex-wrap border-b-2 pb-2 text-sm sm:text-xxs md:text-xs xxl:text-2xl">
                            <label class="w-40 md:w-28 xxl:w-64">Hydrogen type</label>
                            <label class="w-40 md:w-28 xxl:w-64">Units per hour</label>
                            <label class="w-40 md:w-28 xxl:w-64">Duration</label>
                            <label class="w-40 md:w-28 xxl:w-64">Price per unit</label>
                            <label class="w-40 md:w-28 xxl:w-64">Mix CO2</label>
                            <label class="w-40 md:w-28 xxl:w-64">Trade type</label>
                            <label class="w-40 md:w-28 xxl:w-64">Expire in</label>
                        </div>

                        <!--Creation form-->
                        <form class="flex flex-row justify-between flex-wrap text-sm xxl:text-3xl" wire:submit.prevent="submit">
                            <div class="w-40 md:w-28 xxl:w-64 pt-5">
                                <fieldset class="grid grid-cols-2 grid-rows-2">
                                    <div>
                                        <input class="form-radio bg-gray-200 text-typeGreen-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" wire:change="composeChart" name="hydrogen_type" value="green">
                                        <label class="pl-4 sm:pl-1 md:pl-1">green</label>
                                    </div>

                                    <div>
                                        <input class="form-radio bg-gray-200 text-typeBlue-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" wire:change="composeChart" name="hydrogen_type" value="blue">
                                        <label class="pl-4 sm:pl-1 md:pl-1">blue</label>
                                    </div>

                                    <div class="pt-2">
                                        <input class="form-radio bg-gray-200 text-typeGrey-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" wire:change="composeChart" name="hydrogen_type" value="grey">
                                        <label class="pl-4 sm:pl-1 md:pl-1">grey</label>
                                    </div>

                                    <div class="pt-2">
                                        <input class="form-radio bg-gray-200 text-typeMix-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" wire:change="composeChart" name="hydrogen_type" value="mix">
                                        <label class="pl-4 sm:pl-1 md:pl-1">mix</label>
                                    </div>
                                </fieldset>
                                @error('hydrogen_type') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-40 md:w-28 xxl:w-64 pt-5">
                                <input class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="units_per_hour" wire:keyup="composeChart">
                                @error('units_per_hour') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-40 md:w-28 xxl:w-64 flex flex-wrap items-start pt-5">
                                <input class="w-2/4 bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="duration" wire:keyup="composeChart">
                                <select class="w-2/4 px-2 py-1" name="duration_type" wire:model="duration_type">
                                    <option value="day">Days</option>
                                    <option value="week">Weeks</option>
                                    <option value="month">Months</option>
                                </select>
                                @error('duration') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-40 md:w-28 xxl:w-64 pt-5">
                                <input class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="price_per_unit">
                                @error('price_per_unit') <span class="text-red-600 text-xs pt-4">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-40 md:w-28 xxl:w-64 pt-5">
                                <input class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="mix_co2">
                                @error('mix_co2') <span class="text-red-600 text-xs pt-4">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-40 md:w-28 xxl:w-64 pt-5">
                                <fieldset class="flex flex-col flex-nowrap gap-4 sm:gap-2">
                                    <div>
                                        <input class="form-radio bg-gray-200 text-typeBlue-500 h-4 w-4" type="radio" wire:model="trade_type" wire:change="composeChart" name="trade_type" value="offer">
                                        <label class="pl-4 sm:pl-1 md:pl-1">offer</label>
                                    </div>

                                    <div>
                                        <input class="form-radio bg-gray-200 text-typeBlue-500 h-4 w-4" type="radio" wire:model="trade_type" wire:change="composeChart" name="trade_type" value="request">
                                        <label class="pl-4 sm:pl-1 md:pl-1">request</label>
                                    </div>
                                </fieldset>
                                @error('trade_type') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="w-40 md:w-28 xxl:w-64 flex flex-col items-start place-content-start pt-5">
                                <div class="flex">
                                    <input class="w-2/4 bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="expires_at">
                                    <select class="w-2/4 pt-1" name="expires_at_type" wire:model="expires_at_type">
                                        <option value="day">Days</option>
                                        <option value="week">Weeks</option>
                                        <option value="month">Months</option>
                                    </select>
                                </div>
                                @error('expires_at') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </form>

                        <!--Overview-->
                        <p class="flex justify-center font-bold pb-12 sm:pb-4 md:pb-4 lg:pb-8 lg:pt-8 xl:pt-12 text-xl sm:text-sm md:text-base xxl:text-2xl">Overview</p>

                        <div class="flex flex-row sm:flex-col h-full">
                            <div class="w-1/3 sm:w-full flex justify-center items-start">
                                <div class="relative flex flex-col w-vw24 h-28vh sm:w-full" style="width: 28vw; height: 32vh;">
                                    <canvas wire:ignore id="canvas-impact" class="flex z-0"></canvas>
                                </div>
                            </div>

                            <div class="w-2/3 ml-20 sm:w-full h-full grid grid-cols-4 grid-rows-3 text-sm sm:text-xxs xxl:text-2xl">
                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Hydrogen type:</p>

                                    <div class="flex flex-row">
                                        @if ($hydrogen_type)
                                            <svg class="fill-current text-type{{ ucfirst($hydrogen_type) }}-500"
                                                 height="24" width="32">
                                                <circle cx="10" cy="12" r="6"/>
                                            </svg>

                                            <p class="flex items-center">{{ $hydrogen_type }}</p>
                                        @else
                                            <p class="sm:text-xs xxl:text-2xl"><b>Not provided.</b></p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Units per hour:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ is_numeric($units_per_hour) ? number_format($units_per_hour, 0, '.', ' ') : 'Not provided.' }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Duration:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ $this->getDurationReadable() }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Mix CO2:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ is_numeric($mix_co2) ? $mix_co2 . '%' : 'Not provided.' }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Total volume:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ $this->getTotalVolumeReadable() }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Price per unit:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ is_numeric($price_per_unit) ? '€ ' . number_format($price_per_unit, 0, '.', ' ') : 'Not provided.' }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Trade type:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ $trade_type ? $trade_type : 'Not provided.' }}</b></p>
                                </div>

                                <div class="flex flex-col gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Expires at:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ $this->getExpiresAtReadable() }}</b></p>
                                </div>

                                <div class="col-start-2 col-span-2 flex flex-row m-auto gap-5 sm:gap-1 md:gap-1 pb-2">
                                    <p>Total value contract:</p>
                                    <p class="sm:text-xxs xxl:text-2xl"><b>{{ $this->getTotalPriceReadable() }}</b></p>
                                </div>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class="flex justify-center gap-10 pt-2">
                            <button
                                class="bg-butOrange hover:bg-orange-600 border-2 border-butOrange hover:border-orange-600 text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                                wire:click="toggleConfirmationStage">
                                Place
                            </button>
                            <button
                                class="modal-close text-gray-600 hover:text-gray-900 transition duration-300 ease-in-out"
                                wire:click="toggleModal">
                                Close
                            </button>
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
                                        class="bg-butOrange hover:bg-orange-600 border-2 border-butOrange hover:border-orange-600 text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                                        wire:click="createListing">
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
        let ctx = null;
        let chart = null

        let colors = {
            "chartDemandColor": "",
            "chartNewTotalLoadColor": "",
            "chartLoadLeftColor": "",
            "chartLoadRemovedColor": "",
            "chartLoadAddedColor": ""
        }

        function setup(chartData) {
            ctx = document.getElementById("canvas-impact").getContext("2d");

            colors["chartDemandColor"] = "#4CD35D";
            colors["chartNewTotalLoadColor"] = "#75d88c";
            colors["chartLoadLeftColor"] = "#d3fdd8";
            colors["chartLoadRemovedColor"] = "#F0CFB3";
            colors["chartLoadAddedColor"] = "#7DB0ED";

            if (chartData.hydrogenType === 'blue') {
                colors["chartDemandColor"] = "#003399";
                colors["chartLoadLeftColor"] = "#cbe4fd";
                colors["chartNewTotalLoadColor"] = "#5ea5f8";
            }
            else if (chartData.hydrogenType === 'grey') {
                colors["chartDemandColor"] = "#909090";
                colors["chartLoadLeftColor"] = "#e8e8e8";
                colors["chartNewTotalLoadColor"] = "#999999";
            }
        }

        function clear() {
            ctx = document.getElementById("canvas-impact").getContext("2d");

            for (let color in colors) {
                colors[color] = "#000000";
            }

            chart = new Chart(ctx, {
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
            ctx = null;
        }

        Livewire.on('listingParametersFilled', function (chartData) {
            setup(chartData);

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
                        borderColor: colors["chartNewTotalLoadColor"],
                        pointHoverBackgroundColor: colors["chartNewTotalLoadColor"],
                        pointBorderColor: colors["chartNewTotalLoadColor"],
                        pointHoverBorderColor: colors["chartNewTotalLoadColor"],
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
                        type: 'line',
                        label: 'Demand',
                        fill: true,
                        backgroundColor: "#00ff0000",
                        pointBackgroundColor: "#fff",
                        borderColor: colors["chartDemandColor"],
                        pointHoverBackgroundColor: colors["chartDemandColor"],
                        pointBorderColor: colors["chartDemandColor"],
                        pointHoverBorderColor: colors["chartDemandColor"],
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
                        backgroundColor: colors["chartLoadLeftColor"],
                        borderColor: colors["chartLoadLeftColor"],
                        yAxisID: "bar-y-axis",
                        data: chartData.loadLeft
                    },
                    {
                        label: 'Load removed',
                        backgroundColor: colors["chartLoadRemovedColor"],
                        borderColor: colors["chartLoadRemovedColor"],
                        yAxisID: "bar-y-axis",
                        data: chartData.loadRemoved
                    },
                    {
                        label: 'Load added',
                        backgroundColor: colors["chartLoadAddedColor"],
                        borderColor: colors["chartLoadAddedColor"],
                        yAxisID: "bar-y-axis",
                        data: chartData.loadAdded
                    },
                ]
            }

            chart = new Chart(ctx, {
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

        Livewire.on('listingParametersCleared', function () {
            if (chart) {
                chart.destroy();
            }

            clear();
        });
    </script>
@endpush

