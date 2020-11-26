<div class="z-40">
    @if($isOpen)
        <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content py-4 text-left px-6">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">Listing</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <div>
                        <p><b>Trade type:</b>           {{ $trade["trade_type"] }}</p>
                        <p><b>Hydrogen type:</b>        {{ $trade["hydrogen_type"] }}</p>
                        <p><b>Units per hour:</b>       {{ $trade["units_per_hour"] }}</p>
                        <p><b>Duration (hours):</b>     {{ $trade["duration"] }}</p>
                        <p><b>Total volume:</b>         {{ $trade["total_volume"] }}</p>
                        <p><b>Price per unit:</b>       {{ $trade["price_per_unit"] }}</p>
                        <p><b>Mix CO2:</b>              {{ $trade["mix_co2"] }}%</p>
                        <p><b>Expires at:</b>           {{ $trade["expires_at"] }}</p>
                        <t/><p>
                            <b>Expires in:</b>
                            {{ $trade["expires_in"]["days"] }} days
                            {{ $trade["expires_in"]["hours"] }} hours
                            {{ $trade["expires_in"]["minutes"] }} minutes
                        </p>
                    </div>

                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        @if(!$trade["responder_id"] && $trade["owner_id"] != auth()->id())
                            <button
                                class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2"
                                wire:click="makeTrade({{ $trade["id"] }})"
                            >
                                {{ $trade["trade_type"] === "offer" ? "Buy" : "Sell" }}
                            </button>
                        @endif
                        <button wire:click="toggleModal" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
