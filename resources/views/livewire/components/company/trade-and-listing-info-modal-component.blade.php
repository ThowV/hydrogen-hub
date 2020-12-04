<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">
                <div class="modal-content flex flex-col w-full h-full p-12 sm:p-4 xxl:p-16 text-left">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-3">
                        @if ($trade->responder)
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
                        @if ($trade->responder)
                            <p>
                                <b>Deal made at:</b>
                                {{ $trade->deal_made_at }}
                            </p>
                        @endif

                        <p>
                            <b>Listing created at:</b>
                            {{ $trade->created_at }}
                        </p>

                        <p>
                            <b>Hydrogen {{ $trade->trade_type == 'offer' ? 'offered' : 'requested' }} by:</b>
                            {{ $trade->owner->full_name }} - {{ $trade->owner->company->name }}
                        </p>

                        @if ($trade->responder)
                            <p>
                                <b>Hydrogen {{ $trade->trade_type == 'offer' ? 'bought' : 'sold' }} by:</b>
                                {{ $trade->responder->full_name }} - {{ $trade->responder->company->name }}
                            </p>
                        @endif

                        <p><b>Trade type:</b>           {{ $trade->trade_type }}</p>
                        <p><b>Hydrogen type:</b>        {{ $trade->hydrogen_type }}</p>
                        <p><b>Units per hour:</b>       {{ number_format($trade->units_per_hour, 0, '.', ' ') }}</p>
                        <p><b>Price per unit:</b> €     {{ number_format($trade->price_per_unit, 0, '.', ' ') }}</p>
                        <p><b>Duration:</b>             {{ $trade->end }}</p>
                        <p><b>Total volume:</b>         {{ number_format($trade->total_volume, 0, '.', ' ') }} units</p>
                        <p><b>Total price:</b> €        {{ number_format($trade->total_price, 0, '.', ' ') }}</p>
                        <p><b>Mix CO2:</b>              {{ $trade->mix_co2 }}%</p>
                        <p><b>Expires at:</b>           {{ $trade->expires_at }}</p>
                    </div>

                    @if ($trade->responder)
                        <a wire:click="downloadPdf">Download pdf (click to download)</a>
                    @endif

                <!--Footer-->
                    <div class="flex justify-center gap-10 pt-2">
                        <button
                            class="modal-close bg-white border-2 border-butOrange hover:bg-gray-400 hover:border-gray-400 text-butOrange hover:text-white text-xs xxl:text-2xl py-1 px-6 xxl:py-2 xxl:px-8  rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                            wire:click="toggleModal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

