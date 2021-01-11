<div>
    <div>
        <p>Information {{ $datetime ? 'for ' . $datetime : '' }}</p>

        <table>
            <tr>
                <td>Demand: {{ $demand }}</td>
                <td>Total load: {{ $totalLoad }}</td>
            </tr>
            <tr>
                <td>Store: {{ $store }}</td>
                <td>Sold: {{ $sold }}</td>
            </tr>
            <tr>
                <td>Produce: {{ $produce }}</td>
                <td>Bought: {{ $bought }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Position: {{ $position }}</td>
            </tr>
        </table>
    </div>

    <hr />

    <div>
        <p>Running trades</p>

        <table>
            <tr>
                <td>Bought:</td>
                <td>Sold:</td>
            </tr>
            <tr>
                <td>
                    @if(count($runningTradesBought) > 0)
                        @foreach($runningTradesBought as $trade)
                            <hr />

                            <p>{{ $trade->totalVolume }} units</p>
                            <p>ends: {{ $trade->end }}</p>
                            <button class="font-semibold underline" wire:click="openTradeEntry({{ $trade }})">Info</button>

                            <hr />
                        @endforeach
                    @else
                        No running bought trades at this time.
                    @endif
                </td>
                <td>
                    @if(count($runningTradesSold) > 0)
                        @foreach($runningTradesSold as $trade)
                            <hr />

                            <p>{{ $trade->totalVolume }} units</p>
                            <p>ends: {{ $trade->end }}</p>
                            <button class="font-semibold underline" wire:click="openTradeEntry({{ $trade }})">Info</button>

                            <hr />
                        @endforeach
                    @else
                        No running sold trades at this time.
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
