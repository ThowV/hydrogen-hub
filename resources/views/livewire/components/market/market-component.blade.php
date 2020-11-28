<div class="flex w-full h-full flex-col">
    <!--Create listing modal-->
    @livewire('components.market.create-listing')

    <!--Respond listing modal-->
    @livewire('components.market.show-listing')

    <!--Header-->
    <div class="z-0 w-full h-24 grid grid-col-2 grid-rows-2">
        <div class="col-start-1 flex flex-row items-baseline py-8 xxl:py-10">
            <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Marketplace</h1>
            <h2 class="font-bold text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
        </div>
        <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
            <h3 class="font-bold text-xs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
        </div>
    </div>

    <!--Content-->
    <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">

        <div class="rounded-lg px-10 bg-white text-gray-700 flex-grow min-h-full overflow-auto">

            <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">

                <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Filters</h2>

                <!--Create modal button-->
                <div class="grid justify-items-end items-start pt-5">                            
                    <button class="flex justify-end items-center bg-butOrange hover:bg-orange-700 text-white text-xs xxl:text-2xl py-2 px-8 xxl:py-4 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out" wire:click="toggleCreateModal">Sell/Request</button>
                </div>                
            </div>    
                
            <!--Filter listings-->
            <form class="flex flex-row justify-between flex-wrap sm:gap-6 md:gap-4 w-full" wire:submit.prevent="updateTrades">
                <div class="w-40 xxl:w-64">
                    <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Hydrogen type</label>

                    <fieldset class="grid grid-cols-2 grid-rows-2 gap-2 pt-2 xxl:text-2xl">
                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeGreen cursor-pointer" id="green" value="green" wire:model="filter.hydrogen_type">
                            <label for="green">green</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeBlue cursor-pointer" id="blue" value="blue" wire:model="filter.hydrogen_type">
                            <label for="blue">blue</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeGrey cursor-pointer" id="grey" value="grey" wire:model="filter.hydrogen_type">
                            <label for="grey">grey</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeMix cursor-pointer" id="mix" value="mix" wire:model="filter.hydrogen_type">
                            <label for="mix">mix</label>
                        </div>
                    </fieldset>
                </div>

                <div class="w-40 xxl:w-64">
                    <label for="units_per_hour" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Units per hour</label>

                    <div class="m-b-30" wire:ignore x-data x-init="initUnitsPerHourSlider">
                        <input type="text" id="units_per_hour" />
                    </div>
                </div>

                <div class="w-40 xxl:w-64">
                    <label for="duration" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Duration (hours)</label>

                    <div class="m-b-30" wire:ignore x-data x-init="initDurationSlider">
                        <input type="text" id="duration" />
                    </div>
                </div>

                <div class="w-40 xxl:w-64">
                    <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Total volume (units)</label>

                    <div class="m-b-30" wire:ignore x-data x-init="initTotalVolumeSlider">
                        <input type="text" id="total_volume" />
                    </div>
                </div>

                <div class="w-40 xxl:w-64">
                    <label for="price_per_unit"class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Price per unit</label>

                    <div class="m-b-30" wire:ignore x-data x-init="initPricePerUnitSlider">
                        <input type="text" id="price_per_unit" />
                    </div>
                </div>

                <div class="w-40 xxl:w-64">
                    <label for="mix_co2" class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Mix CO2</label>

                    <div class="m-b-30" wire:ignore x-data x-init="initMixCO2Slider">
                        <input type="text" id="mix_co2" />
                    </div>
                </div>

                <div class="w-40 pl-10 xxl:w-64">
                    <label class="font-bold sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Trade type</label>

                    <fieldset class="flex flex-col gap-2 pt-2 sm:flex-row xxl:text-2xl">
                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeBlue" id="offer" value="offer" wire:model="filter.trade_type">
                            <label for="offer">offer</label>
                        
                        </div>
                
                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeBlue" id="request" value="request" wire:model="filter.trade_type">
                            <label for="request">request</label>
                        </div>
                    </fieldset>
                </div>

                <div class="flex justify-center items-center md:w-full pt-5 ">
                    <button class="bg-white border-2 border-hovBlue hover:bg-hovBlue text-hovBlue hover:text-white text-xs xxl:text-2xl py-1 px-6 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out" type="submit">Apply</button>
                </div>
            </form>

            

            <!-- Table -->
            <table class="relative w-full overflow-scroll"> 
                <thead>  
                    <!--Sorting-->
                    <tr class="w-full border-b-2">
                        <th class="flex flex-row pt-8 pb-2 justify-between flex-nowrap">
                            @foreach ($sort as $key => $value)
                                <button class="font-medium text-top text-xs xxl:text-xl w-40 text-left md:w-20 sm:w-10" wire:click="changeSort('{{$key}}')">
                                    {{ $value[0] }}
                                    {{ $value[1] == 'ASC' ? '↑' : '' }} {{ $value[1] == 'DESC' ? '↓' : '' }}
                                </button>
                            @endforeach
                            <div class="font-medium text-left items text-xs w-40 md:w-20 sm:w-10 xxl:text-xl xxl:w-64">Expire</div>
                        </th>
                    </tr>
                </thead>

                <tbody class="flex flex-col flex-nowrap overflow-auto h-vh60 xl:h-vh65 xxl:h-vh70">
                    <!--All listings-->
                    <tr class="">
                        @foreach($trades as $trade)
                            <td class="flex flex-row py-8 xxl:py-12 justify-between items-center text-sm sm:text-xs xl:text-base xxl:text-3xl border-b-2 border-gray-200 font-medium" wire:click="openRespondModal({{ $trade["id"] }})">
                                <p class="w-40 md:w-20 sm:w-10 xxl:w-64">{{ $trade["hydrogen_type"] }}</p>
                                <p class="w-40 md:w-20 sm:w-10 xxl:w-64">{{ $trade["units_per_hour"] }}/h</p>
                                <p class="w-40 md:w-20 sm:w-10 xxl:w-64">{{ $trade["duration"] }}</p>
                                <p class="w-40 md:w-20 sm:w-10 xxl:w-64">Total volume units</p>
                                <p class="w-40 md:w-20 sm:w-10 xxl:w-64">€{{ $trade["price_per_unit"] }}</p>
                                <p class="w-40 md:w-20 sm:w-10 xxl:w-64">{{ $trade["mix_co2"] }}%</p>
                                <button class="w-40 md:w-20 sm:w-10 text-left xxl:w-64">(click to open)</button>
                                <p class="w-40 md:w-20 text-xs xl:text-sm xxl:text-xl sm:w-10 xxl:w-64">{{ $trade["expires_at"] }}</p>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

                <!--Pagination-->
                <div class="flex self-end w-full xl:h-24 xxl:h-full flex flex-row pt-5">
                    <ul class="w-full grid grid-cols-3 grid-rows-1">
                        <div class="col-start-2 flex justify-center items-center xxl:text-3xl gap-10">
                            <li style="display: {{ $page == 1 ? 'none' : 'block'}}">
                                <button class="font-normal hover:font-bold" wire:click="applyPagination('page_previous', {{ $page-1 }})" >
                                    Previous
                                </button>
                            </li>

                            <li style="display: {{ $page == $paginator['last_page'] ? 'none' : 'block'}}">
                                <button class="font-normal hover:font-bold" wire:click="applyPagination('page_next', {{ $page+1 }})">
                                    Next
                                </button>
                            </li>
                        </div>

                        <div class="col-start-3 flex flex-row justify-end items-center gap-4">
                            <li class="text-xs xxl:text-2xl">
                                Jump to Page

                                <select class="cursor-pointer" title="" wire:model="page" wire:change="updateTrades">
                                    @for($i = 1; $i <= $paginator['last_page']; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </li>

                            <li class="text-xs xxl:text-2xl">
                                Items per Page

                                <select class="cursor-pointer" title="" wire:model="itemsPerPage" wire:change="applyPagination('', {{ $page }})">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </li>
                        </div>
                    </ul>
                </div>
        </div>
    </div>   
</div>

    <script>
        function initUnitsPerHourSlider() {
            $('#units_per_hour').ionRangeSlider({
                skin: 'round',
                type: 'double',
                grid: true,
                min: {{ $filter["units_per_hour"][0] }},
                max: {{ $filter["units_per_hour"][1] }},
                from: {{ $filter["units_per_hour"][0] }},
                to: {{ $filter["units_per_hour"][1] }},
                prettify_enabled: true,
                prettify_separator: ' ',
                postfix: 'u/h',
                onChange: function(data) {
                @this.set('filter.units_per_hour', [data.from, data.to])
                }
            });
        }

        function initDurationSlider() {
            $('#duration').ionRangeSlider({
                skin: 'round',
                type: 'double',
                grid: true,
                min: {{ $filter["duration"][0] }},
                max: {{ $filter["duration"][1] }},
                from: {{ $filter["duration"][0] }},
                to: {{ $filter["duration"][1] }},
                prettify_enabled: true,
                prettify_separator: ' ',
                postfix: 'h',
                onChange: function(data) {
                @this.set('filter.duration', [data.from, data.to])
                }
            });
        }

        function initTotalVolumeSlider() {
            $('#total_volume').ionRangeSlider({
                skin: 'round',
                type: 'double',
                grid: true,
                min: {{ $filter["total_volume"][0] }},
                max: {{ $filter["total_volume"][1] }},
                from: {{ $filter["total_volume"][0] }},
                to: {{ $filter["total_volume"][1] }},
                prettify_enabled: true,
                prettify_separator: ' ',
                postfix: 'u',
                onChange: function(data) {
                @this.set('filter.total_volume', [data.from, data.to])
                }
            });
        }

        function initPricePerUnitSlider() {
            $('#price_per_unit').ionRangeSlider({
                skin: 'round',
                type: 'double',
                grid: true,
                min: {{ $filter["price_per_unit"][0] }},
                max: {{ $filter["price_per_unit"][1] }},
                from: {{ $filter["price_per_unit"][0] }},
                to: {{ $filter["price_per_unit"][1] }},
                prettify_enabled: true,
                prettify_separator: ' ',
                prefix: '€ ',
                onChange: function(data) {
                @this.set('filter.price_per_unit', [data.from, data.to])
                }
            });
        }

        function initMixCO2Slider() {
            $('#mix_co2').ionRangeSlider({
                skin: 'round',
                type: 'double',
                grid: true,
                min: {{ $filter["mix_co2"][0] }},
                max: {{ $filter["mix_co2"][1] }},
                from: {{ $filter["mix_co2"][0] }},
                to: {{ $filter["mix_co2"][1] }},
                prettify_enabled: true,
                prettify_separator: ' ',
                postfix: '%',
                onChange: function(data) {
                @this.set('filter.mix_co2', [data.from, data.to])
                }
            });
        }
    </script>
</div>


