<div class="flex flex-col h-full">
    <div class="px-8" style="height: 50%">
        <p class="font-semibold pb-4">Information {{ $datetime ? 'for ' . $datetime : '' }}</p>
 
        <table class="w-full" style="height: 60%">
            <tbody class="text-sm">
                <tr>
                    <td class="w-1/4">Demand: </td>
                    <td class="w-1/4 font-semibold">{{ $demand }}</td>

                    <td class="w-1/4">Total load:</td> 
                    <td class="w-1/4 font-semibold">{{ $totalLoad }}</td>
                </tr>
                <tr>
                    <td class="w-1/4">Store:</td> 
                    <td class="w-1/4 font-semibold">{{ $store }}</td>

                    <td class="w-1/4">Sold:</td> 
                    <td class="w-1/4 font-semibold">{{ $sold }}</td>
                </tr>
                <tr>
                    <td class="w-1/4">Produce:</td> 
                    <td class="w-1/4 font-semibold">{{ $produce }}</td>

                    <td class="w-1/4">Bought:</td> 
                    <td class="w-1/4 font-semibold">{{ $bought }}</td>
                </tr>
                <tr>
                    <td class="w-1/4">Position:</td> 
                    <td class="w-1/4 font-semibold">{{ $position }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="px-8" style="height: 50%">
        <p class="font-semibold pb-4">Running trades</p>

        <div class="flex w-full">
            <div class="w-full h-full overflow-auto">
                <table class="relative w-full max-h-full">
                    <thead class="sticky top-0 w-full font-semibold text-sm pb-2 border-b-2 bg-white">
                        <td class="">Bought:</td>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="w-full text-sm md:text-xs">
                            <td class="w-2/4 pr-4 align-text-top">
                                @if(count($runningTradesBought) > 0)
                                    @foreach($runningTradesBought as $trade)
                                        <div class="w-full flex justify-between py-1">
                                            <p class="w-56 md:w-32 truncate pr-4">{{ $trade->totalVolume }} units ends: {{ $trade->end }}</p>
                                            <button class="font-semibold underline" wire:click="openTradeEntry({{ $trade }})">Info</button>
                                        </div>
                                    @endforeach
                                @else
                                    No running bought trades at this time.
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-full h-full overflow-auto">
                <table class="relative w-full max-h-full">
                    <thead class="sticky top-0 w-full font-semibold text-sm pb-2 border-b-2 bg-white">
                        <td class="">Sold:</td>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="w-full text-sm md:text-xs">
                            <td class="w-2/4 pr-4 align-text-top">
                                @if(count($runningTradesSold) > 0)
                                    @foreach($runningTradesSold as $trade)
                                        <div class="w-full flex justify-between py-1">
                                            <p class="w-56 md:w-32 truncate pr-4">{{ $trade->totalVolume }} units ends: {{ $trade->end }}</p>
                                            <button class="font-semibold underline" wire:click="openTradeEntry({{ $trade }})">Info</button>  
                                        </div>         
                                    @endforeach
                                @else
                                    No running sold trades at this time.
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>      
        </div>
    </div>
</div>
