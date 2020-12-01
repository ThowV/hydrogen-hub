<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Trades</h2>
    </div>

    @if (count($trades) == 0) <!--empty() does not work here. Investigation needed-->
        <h2 class="grid items-center text-xl xxl:text-3xl">There are no trades made yet.</h2>
    @else
        <table class="w-full">
            <thead>
            <tr class="border-b-2 text-gray-600">
                <th class="text-left sm:text-xs text-sm xxl:text-xl">Deal made at</th>
                <th class="text-left sm:text-xs text-sm xxl:text-xl">Hydrogen type</th>
                <th class="text-left sm:text-xs text-sm xxl:text-xl">Trade type</th>
                <th class="text-left sm:text-xs text-sm xxl:text-xl">Total volume</th>
                <th class="text-left sm:text-xs text-sm xxl:text-xl">Total price</th>
                <th class="text-left sm:text-xs text-sm xxl:text-xl">Duration</th>
            </tr>
            </thead>

            <tbody>
            @foreach($trades as $trade)
                <tr>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        {{ $this->getDate($trade->deal_made_at) }}
                    </td>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        {{ $trade->hydrogen_type }}
                    </td>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        {{ $trade->trade_type }}
                    </td>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        {{ number_format($trade->total_volume, 0, '.', ' ') }}
                    </td>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        {{ number_format($trade->total_price, 0, '.', ' ') }}
                    </td>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        {{ $trade->end }}
                    </td>
                    <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                        <button wire:click="openTrade({{ $trade }})">Info</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
