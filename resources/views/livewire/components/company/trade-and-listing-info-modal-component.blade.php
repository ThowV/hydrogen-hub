<div class="z-40">
    @if($isOpen)
        <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content py-4 text-left px-6">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-3">
                        @if ($trade["responder"])
                            <p class="text-2xl font-bold">Trade</p>
                        @else
                            <p class="text-2xl font-bold">Listing</p>
                        @endif
                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <div>
                        @if ($trade["responder"])
                            <p><b>Deal made at:</b>         {{ $trade["deal_made_at"] }}</p>
                        @endif
                        <p><b>Listing created at:</b>   {{ $trade["created_at"] }}</p>

                        <p><b>Hydrogen {{ $trade["trade_type"] == 'offer' ? 'offered' : 'requested' }} by:</b>
                            {{ $trade["owner"]['full_name'] }} - {{ $trade["owner"]['company']['name'] }}
                        </p>
                        @if ($trade["responder"])
                            <p><b>Hydrogen {{ $trade["trade_type"] == 'offer' ? 'bought' : 'sold' }} by:</b>
                                {{ $trade["responder"]['full_name'] }} - {{ $trade["responder"]['company']['name'] }}
                            </p>
                        @endif

                        <p><b>Trade type:</b>           {{ $trade["trade_type"] }}</p>
                        <p><b>Hydrogen type:</b>        {{ $trade["hydrogen_type"] }}</p>
                        <p><b>Units per hour:</b>       {{ number_format($trade['units_per_hour'], 0, '.', ' ') }}</p>
                        <p><b>Price per unit:</b> €     {{ number_format($trade['price_per_unit'], 0, '.', ' ') }}</p>
                        <p><b>Duration:</b>             {{ $trade["end"] }}</p>
                        <p><b>Total volume:</b>         {{ number_format($trade['total_volume'], 0, '.', ' ') }} units</p>
                        <p><b>Total price:</b> €        {{ number_format($trade['total_price'], 0, '.', ' ') }}</p>
                        <p><b>Mix CO2:</b>              {{ $trade["mix_co2"] }}%</p>
                        <p><b>Expires at:</b>           {{ $trade["expires_at"] }}</p>
                    </div>

                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <button wire:click="toggleModal" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

