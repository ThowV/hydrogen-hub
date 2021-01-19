<div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
    <div class="flex flex-col rounded-lg px-10 bg-white text-gray-700 h-full">
        <div class="w-full flex flex-none justify-between h-24 xxl:h-32">
            <h2 class="flex items-center text-xl md:text-base xxl:text-3xl font-bold">Filters</h2>
            <!--Create modal button-->
            @can('listings.create')
            <div class="pt-5">
                <button
                    class="flex items-center bg-butOrange hover:bg-orange-700 text-white text-xs xxl:text-2xl py-2 px-8 xxl:py-4 xxl:px-10 rounded-lg transition duration-300 ease-in-out"
                    wire:click="openCreateModal">Offer/Request
                </button>
            </div>
            @endcan
        </div>

        <!--Filter listings-->
        <form class="flex flex-none justify-between flex-wrap"
              wire:submit.prevent="updateTrades">
            <table>
                <tr class="flex">
                    <td class="w-full">
                        <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Hydrogen type</label>

                        <fieldset class="grid grid-cols-2 grid-rows-2 gap-2 pt-2 text-sm xl:text-base xxl:text-2xl">
                            <div>
                                <input type="checkbox" class="form-checkbox text-typeGreen-500" id="green"
                                    value="green" wire:model="filter.hydrogen_type">
                                <label class="cursor-pointer" for="green">green</label>
                            </div>

                            <div>
                                <input type="checkbox" class="form-checkbox text-typeBlue-500 cursor-pointer" id="blue"
                                    value="blue" wire:model="filter.hydrogen_type">
                                <label class="cursor-pointer" for="blue">blue</label>
                            </div>

                            <div>
                                <input type="checkbox" class="form-checkbox text-typeGrey-500 cursor-pointer" id="grey"
                                    value="grey" wire:model="filter.hydrogen_type">
                                <label class="cursor-pointer" for="grey">grey</label>
                            </div>

                            <div>
                                <input type="checkbox" class="form-checkbox text-typeMix-500 cursor-pointer" id="mix"
                                    value="mix" wire:model="filter.hydrogen_type">
                                <label class="cursor-pointer" for="mix">mix</label>
                            </div>
                        </fieldset>
                    </td>

                    <td class="w-full grid">
                        <label for="units_per_hour" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Units per
                            hour</label>

                        <div class="w-full grid items-end cursor-pointer pr-8" wire:ignore x-data x-init="initSlider('units_per_hour', 'u/h')">
                            <input type="text" id="units_per_hour"/>
                            <div class="flex justify-between text-sm pt-2">
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="units_per_hour_input_from"/>
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="units_per_hour_input_to"/>
                            </div>
                        </div>
                    </td>

                    <td class="w-full grid">
                        <label for="duration" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Duration
                            (hours)</label>

                        <div class="grid items-end cursor-pointer pr-8" wire:ignore x-data x-init="initSlider('duration', 'h')">
                            <input type="text" id="duration"/>
                            <div class="flex justify-between text-sm pt-2">
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="duration_input_from"/>
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="duration_input_to"/>
                            </div>
                        </div>
                    </td>

                    <td class="w-full grid">
                        <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Total volume (units)</label>

                        <div class="grid items-end cursor-pointer pr-8" wire:ignore x-data x-init="initSlider('total_volume', 'u')">
                            <input type="text" id="total_volume"/>
                            <div class="flex justify-between text-sm pt-2">
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="total_volume_input_from"/>
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="total_volume_input_to"/>
                            </div>
                        </div>
                    </td>

                    <td class="w-full grid">
                        <label for="price_per_unit" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Price per unit</label>

                        <div class="grid items-end cursor-pointer pr-8" wire:ignore x-data x-init="initSlider('price_per_unit', '', '€ ')">
                            <input type="text" id="price_per_unit"/>
                            <div class="flex justify-between text-sm pt-2">
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="price_per_unit_input_from"/>
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="price_per_unit_input_to"/>
                            </div>
                        </div>
                    </td>

                    <td class="w-full grid">
                        <label for="mix_co2" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Mix CO2</label>

                        <div class="grid items-end cursor-pointer pr-8" wire:ignore x-data x-init="initSlider('mix_co2', '%')">
                            <input type="text" id="mix_co2"/>
                            <div class="flex justify-between text-sm pt-2">
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="mix_co2_input_from"/>
                                <input class="w-5/12 bg-gray-200 rounded-full text-center" id="mix_co2_input_to"/>
                            </div>
                        </div>
                    </td>

                    <td class="w-full">
                        <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Trade type</label>

                        <fieldset class="flex flex-col gap-2 pt-2 text-sm xl:text-base  xxl:text-2xl">
                            <div class="">
                                <input type="checkbox" class="form-checkbox text-typeBlue cursor-pointer" id="offer" value="offer"
                                    wire:model="filter.trade_type">
                                <label class="cursor-pointer" for="offer">offer</label>
                            </div>

                            <div class="">
                                <input type="checkbox" class="form-checkbox text-typeBlue cursor-pointer" id="request" value="request"
                                    wire:model="filter.trade_type">
                                <label class="cursor-pointer" for="request">request</label>
                            </div>
                        </fieldset>
                    </td>

                    <td class="w-full my-auto text-right">
                        <button class="bg-gray-100 hover:bg-red-500 border-2 border-gray-500 hover:border-red-500 text-gray-600 hover:text-white text-xs xxl:text-2xl py-1 px-6 xxl:py-2 xxl:px-10 rounded-lg transition duration-200 ease-in-out"
                        wire:click="resetFilters">Reset</button>
                    </td>
                </tr>
            </table>
        </form>

        <!--Listings table-->
        <div class="flex flex-auto h-vh50">
            <div class="{{ count($trades) < $itemsPerPage ? '' : 'flex-grow' }} w-full overflow-auto">
                <table class="relative w-full max-h-full">
                    <!-- Table head -->
                    <thead class="sticky top-0 bg-white">
                        <tr class="flex border-b-2 pt-4 pb-2 text-left text-xs xxl:text-sm">
                            <!--Sorting-->
                            @foreach ($sort as $key => $value)
                            <th class="w-full">
                                <button class="text-top"
                                        wire:click="changeSort('{{$key}}')">
                                    {{ $value[0] }}
                                    {{ $value[1] == 'ASC' ? '↑' : '' }} {{ $value[1] == 'DESC' ? '↓' : '' }}
                                </button>
                            </th>
                            @endforeach
                            <th class="font-normal w-full">
                                Expires at
                            </th>
                        </tr>
                    </thead>

                    <!-- Table content -->
                    <tbody class="divide-y">
                    @foreach($trades as $trade)
                        <tr class="w-full flex flex-row py-8 md:py-5 xxl:py-12 items-center text-sm sm:text-xs xl:text-base xxl:text-3xl border-gray-200">
                            <td class="flex w-full">
                                <svg class="fill-current text-type{{ ucfirst($trade["hydrogen_type"]) }}-500"
                                     height="24" width="50">
                                    <circle cx="10" cy="12" r="6"/>
                                </svg>
                                <p>{{ $trade->hydrogen_type }}</p>
                            </td>

                            <td class="w-full">
                                {{ number_format($trade->units_per_hour, 0, '.', ' ') }}/h
                            </td>

                            <td class="w-full">
                                {{ $trade->end }}
                            </td>

                            <td class="w-full">
                                {{ number_format($trade->total_volume, 0, '.', ' ') }} units
                            </td>

                            <td class="w-full">
                                € {{ number_format($trade->price_per_unit, 0, '.', ' ') }}
                            </td>

                            <td class="w-full">
                                {{ $trade->mix_co2 }}%
                            </td>

                            <td class="flex items-center w-full">
                                @can('listings.read')
                                    @if(!$trade->responder_id)
                                        @if($trade->owner_id != auth()->id())
                                            @if($trade->trade_type === "offer" && auth()->user()->can('listings.buy'))
                                                <button
                                                    class="w-32 md:w-24 sm:w-20 bg-blue-100 hover:bg-hovBlue border-2 border-hovBlue text-hovBlue hover:text-white text-xs sm:text-xxs xxl:text-2xl py-2 rounded-lg transition duration-300 ease-in-out"
                                                    wire:click="openListing({{ $trade }})"
                                                >
                                                    Buy - Details
                                                </button>
                                            @elseif($trade->trade_type === "request" && auth()->user()->can('listings.sellto'))
                                                <button
                                                    class="w-32 md:w-24 sm:w-20 bg-blue-100 hover:bg-hovBlue border-2 border-hovBlue text-hovBlue hover:text-white text-xs sm:text-xxs xxl:text-2xl py-2 rounded-lg transition duration-300 ease-in-out"
                                                    wire:click="openListing({{ $trade }})"
                                                >
                                                    Sell - Details
                                                </button>
                                            @endif
                                        @else
                                            <button
                                                class="w-32 md:w-24 sm:w-20 bg-gray-100 hover:bg-gray-500 border-2 border-gray-500 text-gray hover:text-white text-xs sm:text-xxs xxl:text-2xl py-2 rounded-lg transition duration-300 ease-in-out"
                                                wire:click="openListing({{ $trade }})">
                                                Own - Details
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    Not permitted
                                @endif
                            </td>

                            <td class="w-full">
                                {{ $trade->expires_at }}
                            </td>
                        </tr>
                    @endforeach
                    <tbody>
                </table>
            </div>
        </div>

        <!--Pagination-->
        @if (!(count($trades) < $itemsPerPage) || (count($trades) < $itemsPerPage && $page != 1))
        <div class="flex flex-none py-2">
            <ul class="w-full grid grid-cols-3">
                <div class="col-start-1 flex justify-start items-end xxl:text-3xl">
                    <li class="text-xs xxl:text-2xl">
                        Jump to Page
                        <select class="cursor-pointer" title="" wire:click="updateTrades" wire:model="page" wire:change="updateTrades">
                            @for($i = 1; $i <= $paginator['last_page']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </li>
                </div>

                <div class="col-start-2 flex justify-center items-end xxl:text-3xl gap-10">
                    <li style="display: {{ $page == 1 ? 'none' : 'block'}}">
                        <button class="text-sm font-normal hover:font-bold transaction duration-300"
                                wire:click="applyPagination('page_previous', {{ $page-1 }})">
                            Previous
                        </button>
                    </li>

                    <li style="display: {{ $page == $paginator['last_page'] ? 'none' : 'block'}}">
                        <button class="text-sm font-normal hover:font-bold transaction duration-300"
                                wire:click="applyPagination('page_next', {{ $page+1 }})">
                            Next
                        </button>
                    </li>
                </div>

                <div class="col-start-3 flex justify-end items-end">
                    <li class="text-xs xxl:text-2xl">
                        Items per Page
                        <select class="cursor-pointer" title="" wire:model="itemsPerPage"
                                wire:change="applyPagination('', {{ $page }})">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </li>
                </div>
            </ul>
        </div>
        @endif
    </div>
</div>

<!-- Range slider -->
@push('scripts')
    <script>
        let sliders = [];

        function setInputs(sliderId, data) {
            $("#" + sliderId + "_input_from").prop("value", data.from);
            $("#" + sliderId + "_input_to").prop("value", data.to);

            @this.set("filter." + sliderId, [data.from, data.to])
        }

        function updateInput(sliderId, inputBound) {
            let data = $("#" + sliderId).data("ionRangeSlider");
            let dataFrom = data.result.from;
            let dataTo = data.result.to;
            let dataMin = data.result.min;
            let dataMax = data.result.max;
            let inputId = null;

            // Determine which input id to use for the update
            if (inputBound === 0) {
                inputId = "#" + sliderId + "_input_from";
            }
            else if (inputBound === 1) {
                inputId = "#" + sliderId + "_input_to";
            }

            if (inputId) {
                let inputValue = $(inputId).prop("value");

                // Validate
                if (inputValue < dataMin) {
                    inputValue = dataMin;
                }
                if (inputValue > dataMax) {
                    inputValue = dataMax;
                }
                if (inputBound === 0 && inputValue > dataTo) {
                    inputValue = dataTo;
                }
                if (inputBound === 1 && inputValue < dataFrom) {
                    inputValue = dataFrom;
                }

                // Update
                if (inputBound === 0) {
                    setInputs(sliderId, {from: inputValue, to: dataTo});
                    data.update({from: inputValue, to: dataTo});
                }
                else if (inputBound === 1) {
                    setInputs(sliderId, {from: dataFrom, to: inputValue});
                    data.update({from: dataFrom, to: inputValue});
                }
            }
        }

        function initSlider(sliderId, postfix='', prefix='') {
            filter = @json($filter);

            sliders[sliderId] = $(`#${sliderId}`).ionRangeSlider({
                skin: 'round',
                type: 'double',
                min: filter[sliderId][0],
                max: filter[sliderId][1],
                from: filter[sliderId][0],
                to: filter[sliderId][1],
                prettify_enabled: true,
                prettify_separator: ' ',
                postfix: postfix,
                prefix: prefix,
                onStart: (data) => setInputs(sliderId, data),
                onChange: (data) => setInputs(sliderId, data),
                onFinish: (data) => setInputs(sliderId, data)
            });

            $(`#${sliderId}_input_from`).on("change", () => updateInput(sliderId, 0));
            $(`#${sliderId}_input_to`).on("change", () => updateInput(sliderId, 1));
        }

        Livewire.on('resetFilters', function(filters) {
            const fixPositions = ['post', 'post', 'post', 'pre', 'post']
            const fixes = ['u/h', 'h', 'u', '€ ', '%'];
            const sliderIds = ['units_per_hour', 'duration', 'total_volume', 'price_per_unit', 'mix_co2'];

            for (let i = 0; i < sliderIds.length; i++) {
                $(`#${sliderIds[i]}`).data("ionRangeSlider").reset();
            }
        });
    </script>
@endpush
