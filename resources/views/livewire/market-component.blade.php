<div>
    <button wire:click="openCreateModal">Open create</button>

    @if($isCreateModalOpen)
        <form wire:submit.prevent="submit">
            <div>
                <label style="font-weight: bold">Trade type</label>

                <fieldset>
                    <input type="radio" wire:model="trade_type" name="trade_type" value="offer">
                    <label>offer</label>

                    <input type="radio" wire:model="trade_type" name="trade_type" value="request">
                    <label>request</label>
                </fieldset>

                @error('trade_type') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-weight: bold">Hydrogen type</label>

                <fieldset>
                    <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="green">
                    <label>green</label>

                    <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="blue">
                    <label>blue</label>

                    <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="grey">
                    <label>grey</label>

                    <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="mix">
                    <label>mix</label>
                </fieldset>

                @error('hydrogen_type') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-weight: bold">Units per hour</label>
                <input type="text" placeholder="Enter amount" wire:model="units_per_hour">
                @error('units_per_hour') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-weight: bold">Duration</label>
                <input type="text" placeholder="Enter amount" wire:model="duration">

                <select name="duration_type" wire:model="duration_type">
                    <option value="day">Days</option>
                    <option value="week">Weeks</option>
                    <option value="month">Months</option>
                </select>

                @error('duration') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-weight: bold">Price per unit</label>
                <input type="text" placeholder="Enter amount" wire:model="price_per_unit">
                @error('price_per_unit') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-weight: bold">Mix CO2</label>
                <input type="text" placeholder="Enter amount" wire:model="mix_co2">
                @error('mix_co2') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-weight: bold">Expires in</label>
                <input type="text" placeholder="Enter amount" wire:model="expires_at">

                <select name="expires_at_type" wire:model="expires_at_type">
                    <option value="day">Days</option>
                    <option value="week">Weeks</option>
                    <option value="month">Months</option>
                </select>

                @error('expires_at') <span>{{ $message }}</span> @enderror
            </div>

            <button type="submit">Place</button>
        </form>

        <button wire:click="closeCreateModal">Close create modal</button>
    @endif

    @if($isRespondModalOpen)
        <hr><hr><hr>

        <p><b>Trade type:</b> {{ $trade["trade_type"] }}</p>
        <p><b>Hydrogen type:</b> {{ $trade["hydrogen_type"] }}</p>
        <p><b>Units per hour:</b> {{ $trade["units_per_hour"] }}</p>
        <p><b>Duration (needs to be transformed):</b> {{ $trade["duration"] }}</p>
        <p><b>Price per unit:</b> {{ $trade["price_per_unit"] }}</p>
        <p><b>Mix CO2:</b> {{ $trade["mix_co2"] }}%</p>
        <p><b>Expires in (needs to be transformed):</b> {{ $trade["expires_at"] }}</p>

        <button wire:click="closeRespondModal">Close respond modal</button>
    @endif

    <hr><hr><hr>

    @foreach($trades as $trade)
        <div wire:click="openRespondModal({{ $trade["id"] }})">
            <p>{{ $trade["id"] }} - {{ $trade["trade_type"] }} (click to open)</p>
        </div>
    @endforeach
</div>


