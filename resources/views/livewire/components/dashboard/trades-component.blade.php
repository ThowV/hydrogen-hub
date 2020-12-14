<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Trades</h2>
    </div>

    <table class="w-full">
        <thead>
        <tr class="border-b-2 text-gray-600">
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Time</th>
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Hydrogen type</th>
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Total volume</th>
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Price per unit</th>
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Duration</th>
        </tr>
        </thead>

        <tbody>
        @foreach($trades as $trade)
            <tr>
                <td wire:poll.1s class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                    {{ $trade->time_since_deal }}
                </td>
                <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                    {{ $trade->hydrogen_type }}
                </td>
                <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                    {{ number_format($trade->total_volume, 0, '.', ' ') }} units
                </td>
                <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                    € {{ number_format($trade->price_per_unit, 0, '.', ' ') }}
                </td>
                <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                    {{ $trade->end }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>