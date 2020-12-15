<div class="w-full h-full">
    <div class="flex flex-none w-full h-12 xxl:h-24">
        <h2 class="text-base xxl:text-3xl font-bold">Trades</h2>
    </div>

    @if (count($trades) == 0) <!--empty() does not work here. Investigation needed-->
    <h2 class="text-sm text-center">There are no trades made yet.</h2>
    @else

    <table class="w-full flex-auto">
        <thead>
        <tr class="border-b-2 text-gray-600 text-left text-xs xxl:text-xl">
            <th>Deal made at</th>
            <th>Hydrogen type</th>
            <th>Trade type</th>
            <th>Total volume</th>
            <th>Total price</th>
            <th>Duration</th>
        </tr>
        </thead>

        <tbody>
        @foreach($trades as $trade)
            <tr class="text-xs xl:text-sm xxl:text-2xl">
                <td class="py-3 xxl:py-5">
                    {{ $this->getDate($trade->deal_made_at) }}
                </td>
                <td class="py-3 xxl:py-5">
                    {{ $trade->hydrogen_type }}
                </td>
                <td class="py-3 xxl:py-5">
                    {{ $trade->trade_type }}
                </td>
                <td class="py-3 xxl:py-5">
                    {{ number_format($trade->total_volume, 0, '.', ' ') }} units
                </td>
                <td class="py-3 xxl:py-5">
                    € {{ number_format($trade->total_price, 0, '.', ' ') }}
                </td>
                <td class="py-3 xxl:py-5">
                    {{ $trade->end }}
                </td>
                <td class="py-3 xxl:py-5">
                    <button class="font-semibold" wire:click="openTrade({{ $trade }})">Info</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
