<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-w-full min-h-full grid col-start-1 row-start-2 col-span-7 mx-10 row-span-4 bg-white rounded shadow-lg z-50 ">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content flex flex-col p-8 text-left w-full h-full">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-5">
                        <p class="text-2xl font-bold">{{ $trade["trade_type"] === "offer" ? "Buy" : "Sell" }}</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer h-full z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex justify-center font-bold pb-12 text-xl">Overview</div>

                    <!--Body-->
                    <div class="grid grid-cols-6 grid-rows-4 gap-10">
                        <div class="graph row-span-3 col-span-2">
                            <img class="w-full h-full px-10 object-fit" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.stack.imgur.com%2FveUID.png&f=1&nofb=1" alt="placeholder">
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Hydrogen type:</p>
                            <div class="flex flex-row">
                                <svg class="fill-current text-type{{ ucfirst($trade["hydrogen_type"]) }}-500" height="24" width="50">
                                    <circle cx="10" cy="12" r="6" />
                                </svg> 
                            <p class="text-lg"><b> {{ $trade["hydrogen_type"] }} </b></p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Units per hour:</p>
                            <p class="text-lg"><b> {{ $trade["units_per_hour"] }}/h </b></p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Duration (hours):</p>
                            <p class="text-lg"><b> {{ $trade["duration"] }}</b></p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Mix CO2:</p>
                            <p class="text-lg"><b> {{ $trade["mix_co2"] }}%</b></p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Total volume:</p>
                            <p class="text-lg"><b> {{ $trade["total_volume"] }} units</b></p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Price per unit:</p>
                            <p class="text-lg"><b> €{{ $trade["price_per_unit"] }}</b></p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Trade type:</p>
                            <p class="text-lg"><b> {{ $trade["trade_type"] }}</b></p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-sm">Expires at:</p>
                            <p class="text-base"><b> {{ $trade["expires_at"] }}</b></p>
                        </div>

                        <t/><p>
                            <b>Expires in:</b>
                            {{ $trade["expires_in"]["days"] }} days
                            {{ $trade["expires_in"]["hours"] }} hours
                            {{ $trade["expires_in"]["minutes"] }} minutes
                        </p>
                    </div>

                    <!--Footer-->
                    <div class="h-full w-full">
                        <div class="m-auto w-full h-full flex justify-center items-center gap-10">
                            @if(!$trade["responder_id"] && $trade["owner_id"] != auth()->id())
                                <button
                                    class="bg-personal hover:bg-hovBlue border-2 border-personal hover:border-hovBlue text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                                    wire:click="makeTrade({{ $trade["id"] }})"
                                >
                                    {{ $trade["trade_type"] === "offer" ? "Buy" : "Sell" }}
                                </button>
                            @endif
                            <button wire:click="toggleModal" class="modal-close bg-white border-2 border-hovBlue hover:bg-gray-400 hover:border-gray-400 text-hovBlue hover:text-white text-xs xxl:text-2xl py-1 px-6 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
