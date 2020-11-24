<div>
    <button wire:click="toggleCreateModal">Open create</button>

    <table style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; padding: 10px;">
                <!--Create listing modal-->
                @if($isCreateModalOpen)
                    @livewire('components.market.create-listing')

                    <button wire:click="toggleCreateModal">Close create modal</button>
                @endif
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid black; padding: 10px;">
                <!--Filter listings form-->
                <form wire:submit.prevent="updateTrades">
                    <div>
                        <label style="font-weight: bold">Hydrogen type</label>

                        <fieldset>
                            <input type="checkbox" id="green" value="green" wire:model="filter.hydrogen_type">
                            <label for="green">green</label>

                            <input type="checkbox" id="blue" value="blue" wire:model="filter.hydrogen_type">
                            <label for="blue">blue</label>

                            <input type="checkbox" id="grey" value="grey" wire:model="filter.hydrogen_type">
                            <label for="grey">grey</label>

                            <input type="checkbox" id="mix" value="mix" wire:model="filter.hydrogen_type">
                            <label for="mix">mix</label>
                        </fieldset>
                    </div>

                    <div>
                        <label for="units_per_hour" style="font-weight: bold">Units per hour</label>

                        <div class="m-b-30" wire:ignore x-data x-init="
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
                        ">
                            <input type="text" id="units_per_hour" />
                        </div>
                    </div>

                    <div>
                        <label for="duration" style="font-weight: bold">Duration (hours)</label>

                        <div class="m-b-30" wire:ignore x-data x-init="
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
                        ">
                            <input type="text" id="duration" />
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: bold">Total volume (units)</label>

                        <div class="m-b-30" wire:ignore x-data x-init="
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
                        ">
                            <input type="text" id="total_volume" />
                        </div>
                    </div>

                    <div>
                        <label for="price_per_unit" style="font-weight: bold">Price per unit</label>

                        <div class="m-b-30" wire:ignore x-data x-init="
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
                        ">
                            <input type="text" id="price_per_unit" />
                        </div>
                    </div>

                    <div>
                        <label for="mix_co2" style="font-weight: bold">Mix CO2</label>

                        <div class="m-b-30" wire:ignore x-data x-init="
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
                        ">
                            <input type="text" id="mix_co2" />
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: bold">Trade type</label>

                        <fieldset>
                            <input type="checkbox" id="offer" value="offer" wire:model="filter.trade_type">
                            <label for="offer">offer</label>

                            <input type="checkbox" id="request" value="request" wire:model="filter.trade_type">
                            <label for="request">request</label>
                        </fieldset>
                    </div>

                    <button type="submit">Apply</button>
                </form>
            </td>

            <td style="border: 1px solid black; padding: 10px;">
                <!--All listings-->
                @foreach($trades as $trade)
                    <div wire:click="openRespondModal({{ $trade["id"] }})">
                        <p>{{ $trade["id"] }} - {{ $trade["hydrogen_type"] }} (click to open)</p>
                    </div>
                @endforeach
            </td>

            <td style="border: 1px solid black; padding: 10px;">
                <!--Open listing modal-->
                @if($isRespondModalOpen)
                    @livewire('components.market.show-listing', ['trade' => $trade["id"]])

                    <button wire:click="closeRespondModal">Close respond modal</button>
                @endif
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid black; padding: 10px;">
                <!--Pagination-->
                <ul>
                    <li style="display: {{ $page == 1 ? 'none' : 'block'}}">
                        <button wire:click="applyPagination('page_previous', {{ $page-1 }})" >
                            Previous
                        </button>
                    </li>

                    <li style="display: {{ $page == $paginator['last_page'] ? 'none' : 'block'}}">
                        <button wire:click="applyPagination('page_next', {{ $page+1 }})">
                            Next
                        </button>
                    </li>

                    <li>
                        Jump to Page

                        <select title="" wire:model="page" wire:change="updateTrades">
                            @for($i = 1; $i <= $paginator['last_page']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </li>

                    <li>
                        Items Per Page

                        <select title="" wire:model="itemsPerPage" wire:change="applyPagination('', {{ $page }})">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </li>
                </ul>
            </td>
        </tr>
    </table>
</div>


