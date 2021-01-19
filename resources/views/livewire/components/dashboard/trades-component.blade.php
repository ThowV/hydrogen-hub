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
                @foreach($trades as $i=>$trade)
                    <tr>
                        <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl" id="trade-time-{{$i}}">
                            Loading...
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

@push('scripts')
    <script>
        let trades = @json($trades);

        for (let tradeId in trades) {
            let trade = trades[tradeId];
            let tradeDate = new Date(trade.deal_made_at);
            let tradeStamp = tradeDate.getTime();

            let test = 0;

            let timer = setInterval(function() {
                let newDate = new Date();
                let newStamp = newDate.getTime();
                let diff = Math.round((newStamp-tradeStamp) / 1000);

                // Calculate time values
                let days = Math.floor(diff / (24 * 60 * 60)); /* though I hope she won't be working for consecutive days :) */
                diff = diff - (days * 24 * 60 * 60);
                let hours = Math.floor(diff / (60 * 60));
                diff = diff - (hours * 60 * 60);
                let minutes = Math.floor(diff/(60));
                diff = diff - (minutes * 60);
                let seconds = diff;

                // Create readable string
                let secondsPart =   hours < 1 ? ` ${seconds} second${seconds > 1 ? 's' : ''}` : '';
                let minutesPart =   days < 1 ? ` ${minutes} minute${minutes > 1 ? 's' : ''}` : '';
                let hoursPart =     hours > 0 ? ` ${hours} hour${hours > 1 ? 's' : ''}` : '';
                let daysPart =      days > 0 ? `${days} day${days > 1 ? 's' : ''}` : '';
                let timeString = daysPart + hoursPart + minutesPart + secondsPart;

                document.getElementById(`trade-time-${tradeId}`).innerHTML = timeString;
            }, 1000);
        }
    </script>
@endpush
