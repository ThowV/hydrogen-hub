<div class="flex flex-col h-full">
    <div class="px-8" style="height: 50%">
        <div class="w-full xxl:h-12 flex justify-between">
            <p class="font-semibold pb-4">Information {{ $datetime ? 'for ' . $datetime : '(click on an hour in the graph to view)' }}</p>

            @canany(['company.produced.update', 'company.stored.update', 'company.demand.update'])
                @if ($datetime != '' && $chartType != "combined")
                    <div class="flex justify-items-end items-start">
                        @if (!$editState)
                            <svg wire:click="toggleEditState" class="opacity-25 hover:opacity-75 transaction duration-300" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20">
                                <path id="Icon_ionic-md-settings" data-name="Icon ionic-md-settings" d="M20.97,14.375a6.254,6.254,0,0,0,.051-1c0-.35-.051-.65-.051-1l2.147-1.65a.459.459,0,0,0,.1-.65l-2.046-3.45a.5.5,0,0,0-.614-.2L18,7.425a7.443,7.443,0,0,0-1.738-1l-.358-2.65a.548.548,0,0,0-.511-.4H11.3a.548.548,0,0,0-.511.4l-.409,2.65a8.66,8.66,0,0,0-1.739,1l-2.557-1a.479.479,0,0,0-.614.2l-2.046,3.45a.6.6,0,0,0,.1.65l2.2,1.65c0,.35-.051.65-.051,1s.051.65.051,1l-2.148,1.65a.459.459,0,0,0-.1.65l2.046,3.45a.5.5,0,0,0,.614.2l2.557-1a7.442,7.442,0,0,0,1.738,1l.409,2.65a.5.5,0,0,0,.511.4h4.091a.548.548,0,0,0,.511-.4l.41-2.65a8.655,8.655,0,0,0,1.738-1l2.557,1a.479.479,0,0,0,.614-.2l2.046-3.45a.6.6,0,0,0-.1-.65Zm-7.62,2.5a3.5,3.5,0,1,1,3.58-3.5A3.519,3.519,0,0,1,13.349,16.875Z" transform="translate(-3.375 -3.375)" fill="#4a4a4a"/>
                            </svg>
                        @else
                            <button wire:click="saveEdits" class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-green-200">
                                ✓
                            </button>
                            <button wire:click="toggleEditState" class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-red-200">
                                ✕
                            </button>
                        @endif
                    </div>
                @endif
            @endcan
        </div>

        @if($editState)
            <div class="text-left">
                <p class="font-semibold text-gray-600 text-xs xxl:text-xl mb-1">Password for confirmation</p>
                <input
                    class="w-4/5 rounded-xl bg-gray-200 px-4 py-1 text-sm transaction duration-300 hover:bg-gray-300 focus:bg-gray-300"
                    wire:model="password" id="passwordInput" name="passwordInput" type="password" placeholder="******************"
                >
                @error('password') <p class="text-red-600 text-xs pt-4">{{ $message }}</p> @enderror
            </div>
        @endif

        <table class="w-full" style="height: 60%">
            <tbody class="text-sm">
                <tr>
                    <td class="w-1/4">Demand: </td>
                    @if (!$editState)
                        <td class="w-1/4 font-semibold">{{ number_format($demand, 0, '.', ' ') }}</td>
                    @elseif($editState && auth()->user()->can('company.demand.update'))
                        <td class="w-1/4 font-semibold">
                            <input class="w-4/5 rounded-xl bg-gray-200 px-4 py-1 text-sm transaction duration-300 hover:bg-gray-300 focus:bg-gray-300" wire:model="demand" type="text" id="demandInput" name="demandInput">
                            <label for="demandInput">/hour</label>
                            @error('demand') <p class="text-red-600 text-xs pt-4">{{ $message }}</p> @enderror
                        </td>
                    @endif

                    <td class="w-1/4">Total load:</td>
                    <td class="w-1/4 font-semibold">{{ number_format($totalLoad, 0, '.', ' ') }}</td>
                </tr>
                <tr>
                    <td class="w-1/4">Store:</td>
                    @if (!$editState)
                        <td class="w-1/4 font-semibold">{{ number_format($store, 0, '.', ' ') }}</td>
                    @elseif($editState && auth()->user()->can('company.stored.update'))
                        <td class="w-1/4 font-semibold">
                            <input class="w-4/5 rounded-xl bg-gray-200 px-4 py-1 text-sm transaction duration-300 hover:bg-gray-300 focus:bg-gray-300" wire:model="store" type="text" id="storeInput" name="storeInput">
                            <label for="storeInput">/hour</label>
                            @error('store') <p class="text-red-600 text-xs pt-4">{{ $message }}</p> @enderror
                        </td>
                    @endif

                    <td class="w-1/4">Sold:</td>
                    <td class="w-1/4 font-semibold">{{ number_format($sold, 0, '.', ' ') }}</td>
                </tr>
                <tr>
                    <td class="w-1/4">Produce:</td>
                    @if (!$editState)
                        <td class="w-1/4 font-semibold">{{ number_format($produce, 0, '.', ' ') }}</td>
                    @elseif($editState && auth()->user()->can('company.produced.update'))
                        <td class="w-1/4 font-semibold">
                            <input class="w-4/5 rounded-xl bg-gray-200 px-4 py-1 text-sm transaction duration-300 hover:bg-gray-300 focus:bg-gray-300" wire:model="produce" type="text" id="produceInput" name="produceInput">
                            <label for="produceInput">/hour</label>
                            @error('produce') <p class="text-red-600 text-xs pt-4">{{ $message }}</p> @enderror
                        </td>
                    @endif

                    <td class="w-1/4">Bought:</td>
                    <td class="w-1/4 font-semibold">{{ number_format($bought, 0, '.', ' ') }}</td>
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

        <div class="flex w-full flex gap-2">
            <div class="w-full h-64 md:h-56 overflow-auto">
                <table class="relative w-full max-h-full">
                    <thead class="sticky top-0 w-full bg-white">
                        <tr class="w-full border-b-2 flex pb-2 sticky top-0 text-left bg-white font-semibold text-sm">
                            <th>Bought:</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="w-full text-sm md:text-xs">
                            <td class="w-2/4 align-text-top">
                                @if(count($runningTradesBought) > 0)
                                    @foreach($runningTradesBought as $trade)
                                        <div class="w-full flex justify-between py-2">
                                            <p class="w-56 md:w-32 truncate">{{ number_format($trade->totalVolume, 0, '.', ' ') }} units ends: {{ $trade->end }}</p>
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

            <div class="w-full h-64 md:h-56 overflow-y-auto">
                <table class="relative w-full max-h-full">
                    <thead class="sticky top-0 w-full bg-white">
                        <tr class="w-full border-b-2 flex pb-2 sticky top-0 text-left bg-white font-semibold text-sm">
                            <th>Sold:</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="text-sm md:text-xs">
                            <td class="w-2/4 align-text-top">
                                @if(count($runningTradesSold) > 0)
                                    @foreach($runningTradesSold as $trade)
                                        <div class="flex justify-between py-2">
                                            <p class="w-56 md:w-32 truncate">{{ number_format($trade->totalVolume, 0, '.', ' ') }} units ends: {{ $trade->end }}</p>
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
