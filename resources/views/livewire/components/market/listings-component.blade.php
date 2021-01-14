<div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
    <div class="flex flex-col rounded-lg px-10 bg-white text-gray-700 h-full">
        <div class="w-full flex flex-none justify-between h-24 xxl:h-32">
            <h2 class="flex items-center text-xl md:text-base xxl:text-3xl font-bold">Filters</h2>
            <!--Create modal button-->
            @can('listings.create')
            <div class="pt-5">
                <button
                    class="flex items-center bg-butOrange hover:bg-orange-700 text-white text-xs xxl:text-2xl py-2 px-8 xxl:py-4 xxl:px-10 rounded-lg transition duration-300 ease-in-out"
                    wire:click="openCreateModal">Sell/Request
                </button>
            </div>
            @endcan
        </div>

        <!--Filter listings-->
        <form class="flex flex-none justify-between flex-wrap sm:gap-6 md:gap-4"
              wire:submit.prevent="updateTrades">
            <div class="w-32 lg:w-40 xl:w-56 xxl:w-64">
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
            </div>

            <div class="w-32 lg:w-40 xl:w-56 xxl:w-64 grid">
                <label for="units_per_hour" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Units per
                    hour</label>

                <div class="grid items-end cursor-pointer" wire:ignore x-data x-init="initUnitsPerHourSlider">
                    <input type="text" id="units_per_hour"/>
                </div>
            </div>

            <div class="w-32 lg:w-40 xl:w-56 xxl:w-64 grid">
                <label for="duration" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Duration
                    (hours)</label>

                <div class="grid items-end cursor-pointer" wire:ignore x-data x-init="initDurationSlider">
                    <input type="text" id="duration"/>
                </div>
            </div>

            <div class="w-32 lg:w-40 xl:w-56 xxl:w-64 grid">
                <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Total volume (units)</label>

                <div class="grid items-end cursor-pointer" wire:ignore x-data x-init="initTotalVolumeSlider">
                    <input type="text" id="total_volume"/>
                </div>
            </div>

            <div class="w-32 lg:w-40 xl:w-56 xxl:w-64 grid">
                <label for="price_per_unit" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Price per
                    unit</label>

                <div class="grid items-end cursor-pointer" wire:ignore x-data x-init="initPricePerUnitSlider">
                    <input type="text" id="price_per_unit"/>
                </div>
            </div>

            <div class="w-32 lg:w-40 xl:w-56 xxl:w-64 grid">
                <label for="mix_co2" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Mix CO2</label>

                <div class="grid items-end" wire:ignore x-data x-init="initMixCO2Slider">
                    <input type="text" id="mix_co2"/>
                </div>
            </div>

            <div class="w-32 lg:w-40 xl:w-56 pl-10 xxl:w-64">
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
            </div>
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
                                                    class="w-24 md:w-20 sm:w-14 bg-blue-100 hover:bg-hovBlue border-2 border-hovBlue text-hovBlue hover:text-white text-xs sm:text-xxs xxl:text-2xl py-1 rounded-lg transition duration-300 ease-in-out"
                                                    wire:click="openListing({{ $trade }})"
                                                >
                                                    buy
                                                </button>
                                            @elseif($trade->trade_type === "request" && auth()->user()->can('listings.sellto'))
                                                <button
                                                    class="w-24 md:w-20 sm:w-14 bg-blue-100 hover:bg-hovBlue border-2 border-hovBlue text-hovBlue hover:text-white text-xs sm:text-xxs xxl:text-2xl py-1 rounded-lg transition duration-300 ease-in-out"
                                                    wire:click="openListing({{ $trade }})"
                                                >
                                                    sell
                                                </button>
                                            @endif
                                        @else
                                            <button
                                                class="w-24 md:w-20 sm:w-14 bg-gray-100 hover:bg-gray-500 border-2 border-gray-500 text-gray hover:text-white text-xs sm:text-xxs xxl:text-2xl py-1 rounded-lg transition duration-300 ease-in-out"
                                                wire:click="openListing({{ $trade }})">
                                                Own
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
<script>
    function initUnitsPerHourSlider() {
        $('#units_per_hour').ionRangeSlider({
            skin: 'round',
            type: 'double',
            min: {{ $filter["units_per_hour"][0] }},
            max: {{ $filter["units_per_hour"][1] }},
            from: {{ $filter["units_per_hour"][0] }},
            to: {{ $filter["units_per_hour"][1] }},
            prettify_enabled: true,
            prettify_separator: ' ',
            postfix: 'u/h',
            onChange: function (data) {
            @this.set('filter.units_per_hour', [data.from, data.to])
            }
        });
    }

    function initDurationSlider() {
        $('#duration').ionRangeSlider({
            skin: 'round',
            type: 'double',
            min: {{ $filter["duration"][0] }},
            max: {{ $filter["duration"][1] }},
            from: {{ $filter["duration"][0] }},
            to: {{ $filter["duration"][1] }},
            prettify_enabled: true,
            prettify_separator: ' ',
            postfix: 'h',
            onChange: function (data) {
            @this.set('filter.duration', [data.from, data.to])
            }
        });
    }

    function initTotalVolumeSlider() {
        $('#total_volume').ionRangeSlider({
            skin: 'round',
            type: 'double',
            min: {{ $filter["total_volume"][0] }},
            max: {{ $filter["total_volume"][1] }},
            from: {{ $filter["total_volume"][0] }},
            to: {{ $filter["total_volume"][1] }},
            prettify_enabled: true,
            prettify_separator: ' ',
            postfix: 'u',
            onChange: function (data) {
            @this.set('filter.total_volume', [data.from, data.to])
            }
        });
    }

    function initPricePerUnitSlider() {
        $('#price_per_unit').ionRangeSlider({
            skin: 'round',
            type: 'double',
            min: {{ $filter["price_per_unit"][0] }},
            max: {{ $filter["price_per_unit"][1] }},
            from: {{ $filter["price_per_unit"][0] }},
            to: {{ $filter["price_per_unit"][1] }},
            prettify_enabled: true,
            prettify_separator: ' ',
            prefix: '€ ',
            onChange: function (data) {
            @this.set('filter.price_per_unit', [data.from, data.to])
            }
        });
    }

    function initMixCO2Slider() {
        $('#mix_co2').ionRangeSlider({
            skin: 'round',
            type: 'double',
            min: {{ $filter["mix_co2"][0] }},
            max: {{ $filter["mix_co2"][1] }},
            from: {{ $filter["mix_co2"][0] }},
            to: {{ $filter["mix_co2"][1] }},
            prettify_enabled: true,
            prettify_separator: ' ',
            postfix: '%',
            onChange: function (data) {
            @this.set('filter.mix_co2', [data.from, data.to])
            }
        });
    }
</script>
