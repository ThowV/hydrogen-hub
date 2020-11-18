<div>
    <button wire:click="openCreateModal">Open create</button>

    @if($isCreateModalOpen)
        @livewire('components.market.create-listing')

        <button wire:click="closeCreateModal">Close create modal</button>
    @endif

    @if($isRespondModalOpen)
        <hr><hr><hr>

        <p><b>Trade type:</b>       {{ $trade["trade_type"] }}</p>
        <p><b>Hydrogen type:</b>    {{ $trade["hydrogen_type"] }}</p>
        <p><b>Units per hour:</b>   {{ $trade["units_per_hour"] }}</p>
        <p><b>Duration:</b>         {{ $trade["duration"] }}</p>
        <p><b>Price per unit:</b>   {{ $trade["price_per_unit"] }}</p>
        <p><b>Mix CO2:</b>          {{ $trade["mix_co2"] }}%</p>
        <p><b>Expires at:</b>       {{ $trade["expires_at"] }}</p>
        <t/><p>
            <b>Expires in:</b>
            {{ $trade["expires_in"]["days"] }} days
            {{ $trade["expires_in"]["hours"] }} hours
            {{ $trade["expires_in"]["minutes"] }} minutes
        </p>

        @if(!$trade["responder_id"] && $trade["owner_id"] != auth()->id())
            <button wire:click="makeTrade({{ $trade["id"] }})">
                {{ $trade["trade_type"] === "offer" ? "Buy hydrogen" : "Sell hydrogen" }}
            </button>
        @endif

        <button wire:click="closeRespondModal">Close respond modal</button>
    @endif

    <hr><hr><hr>

    @foreach($trades as $trade)
        <div wire:click="openRespondModal({{ $trade["id"] }})">
            <p>{{ $trade["id"] }} - {{ $trade["trade_type"] }} (click to open)</p>
        </div>
    @endforeach
</div>


