<div class="flex flex-col h-full w-full">
    <div class="flex flex-none w-full">
        <h2 class="xxl:text-3xl font-bold pb-6">Trades</h2>
    </div>

    <div class="flex flex-auto w-full h-40">
        <div class="w-full h-full overflow-auto">
            <table class="relative w-full max-h-full">
                <thead class="sticky border-b-2 top-0 w-full bg-white">
                    <tr class="top-0 sticky text-gray-600 text-left text-xs md:text-xxs xxl:text-xl">   
                        <th class="">Time</th>
                        <th class="">Hydrogen type</th>
                        <th class="">Total volume</th>
                        <th class="">Price per unit</th>
                        <th class="">Duration</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @foreach($trades as $trade)
                    <tr>
                        <td wire:poll.1s class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                            {{ $trade->time_since_deal }}
                        </td>
                        <td class="flex items-center py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                            <svg class="fill-current text-type{{ucfirst($trade->hydrogen_type)}}-500" height="24" width="50">
                                <circle cx="10" cy="12" r="6"/>
                            </svg>
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
    </div>
</div>
