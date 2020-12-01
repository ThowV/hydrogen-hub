<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50 ">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content flex flex-col w-full h-full p-8 sm:p-4 xxl:p-12 text-left ">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-5 sm:pb-2">
                        <p class="text-xl xxl:text-4xl font-bold">{{ $trade->trade_type == "offer" ? "Buy" : "Sell" }}</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer h-full z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex justify-center font-bold pb-12 sm:pb-4 text-xl xxl:text-2xl">Overview</div>

                    <!--Body-->
                    <div class="flex flex-row h-full sm:flex-col">

                        <div class="w-1/3 sm:w-full sm:pb-5 flex justify-center items-start">
                            <img class="object-scale-down w-4/6 h-4/6 sm:w-2/6 sm:h-2/6" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.stack.imgur.com%2FveUID.png&f=1&nofb=1" alt="placeholder">
                        </div>

                        <div class="w-2/3 sm:w-full h-full grid grid-cols-4 grid-rows-3">

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Hydrogen type:</p>
                                <div class="flex flex-row items-start">
                                    <svg class="fill-current text-type{{ ucfirst($trade->hydrogen_type) }}-500" height="24" width="24">
                                        <circle cx="10" cy="12" r="6" />
                                    </svg>
                                    <p class="text-lg sm:text-xs xxl:text-2xl"><b> {{ $trade->hydrogen_type }} </b></p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Units per hour:</p>
                                <p class="text-lg sm:text-xs xxl:text-2xl"><b> {{ $trade->units_per_hour }}/h </b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Duration (hours):</p>
                                <p class="text-lg sm:text-xs xxl:text-2xl"><b> {{ $trade->duration }}</b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Mix CO2:</p>
                                <p class="text-lg sm:text-xs xxl:text-2xl"><b> {{ $trade->mix_co2 }}%</b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Total volume:</p>
                                <p class="text-lg sm:text-xs xxl:text-2xl"><b> {{ $trade->total_volume }} units</b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Price per unit:</p>
                                <p class="text-lg sm:text-xs xxl:text-2xl"><b> €{{ $trade->price_per_unit }}</b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Trade type:</p>
                                <p class="text-lg sm:text-xs xxl:text-2xl"><b> {{ $trade->trade_type }}</b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Expires at:</p>
                                <p class="text-base sm:text-xs xxl:text-2xl"><b> {{ $trade->expires_at }}</b></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3 col-start-2 col-span-2 text-sm sm:text-xxs xxl:text-xl">
                                <p class="text-sm sm:text-xxs xxl:text-xl">Total value contract</p>
                                <p class="font-bold text-base sm:text-xs xxl:text-2xl"></p>
                            </div>

                            <div class="flex flex-col gap-5 sm:gap-3 col-start-4 text-sm sm:text-xxs xxl:text-xl">
                            </div>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="w-full h-24 flex justify-center items-center gap-10">
                        @if(!$trade->responder_id && $trade->owner_id != auth()->id())
                            <button
                                class="bg-personal hover:bg-hovBlue border-2 border-personal hover:border-hovBlue text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                                wire:click="makeTrade({{ $trade->id }})"
                            >
                                {{ $trade->trade_type == "offer" ? "Buy" : "Sell" }}
                            </button>
                        @endif
                        <button wire:click="toggleModal" class="modal-close bg-white border-2 border-hovBlue hover:bg-gray-400 hover:border-gray-400 text-hovBlue hover:text-white text-xs xxl:text-2xl py-1 px-6 xxl:py-2 xxl:px-8  rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
