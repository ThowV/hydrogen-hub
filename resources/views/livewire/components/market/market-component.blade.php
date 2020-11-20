<div>
    <button wire:click="openCreateModal">Open create</button>

    <table style="border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; padding: 10px;">
                @if($isCreateModalOpen)
                    @livewire('components.market.create-listing')

                    <button wire:click="closeCreateModal">Close create modal</button>
                @endif
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid black; padding: 10px;">
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
                        <input type="range" min="{{ $bounds["units_per_hour_min"] }}" max="{{ $bounds["units_per_hour_max"] }}" id="units_per_hour" wire:model="filter.units_per_hour">
                        <label>{{ $filter["units_per_hour"] }}</label>
                    </div>

                    <div>
                        <label for="duration" style="font-weight: bold">Duration (hours)</label>
                        <input type="range" min="{{ $bounds["duration_min"] }}" max="{{ $bounds["duration_max"] }}" id="duration" wire:model="filter.duration">
                        <label>{{ $filter["duration"] }}</label>
                    </div>

                    <div>
                        <label style="font-weight: bold">Total volume (units)</label>
                        <input type="range" min="{{ $bounds["total_volume_min"] }}" max="{{ $bounds["total_volume_max"] }}" id="total_volume" wire:model="filter.total_volume">
                        <label>{{ $filter["total_volume"] }}</label>
                    </div>

                    <div>
                        <label for="price_per_unit" style="font-weight: bold">Price per unit</label>
                        <input type="range" min="{{ $bounds["price_per_unit_min"] }}" max="{{ $bounds["price_per_unit_max"] }}" id="price_per_unit" wire:model="filter.price_per_unit">
                        <label>{{ $filter["price_per_unit"] }}</label>
                    </div>

                    <div>
                        <label for="mix_co2" style="font-weight: bold">Mix CO2</label>
                        <input type="range" min="{{ $bounds["mix_co2_min"] }}" max="{{ $bounds["mix_co2_max"] }}" value="50" id="mix_co2" wire:model="filter.mix_co2">
                        <label>{{ $filter["mix_co2"] }}</label>
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
                @foreach($trades as $trade)
                    <div wire:click="openRespondModal({{ $trade["id"] }})">
                        <p>{{ $trade["id"] }} - {{ $trade["trade_type"] }} (click to open)</p>
                    </div>
                @endforeach
            </td>

            <td style="border: 1px solid black; padding: 10px;">
                @if($isRespondModalOpen)
                    @livewire('components.market.show-listing', ['trade' => $trade["id"]])

                    <button wire:click="closeRespondModal">Close respond modal</button>
                @endif
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid black; padding: 10px;">
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


