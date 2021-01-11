<div class="w-full h-full flex flex-col">
    <div class="flex flex-none h-8 xxl:h-12">
        <h2 class="text-base xxl:text-3xl font-bold">{{ $componentType == 'trades' ? 'Trades' : 'Offers & requests' }}</h2>
    </div>

    @if (count($tradeEntries) == 0) <!--empty() does not work here. Investigation needed-->
    <h2 class="text-sm text-center">There are no {{ $componentType == 'trades' ? 'trades' : 'offers or requests' }} made yet.</h2>
    @else

    <div class="flex flex-auto w-full h-40">
        <div class="w-full h-full overflow-auto">
            <table class="relative w-full max-h-full">
                <thead class="sticky border-b-2 top-0 w-full bg-white">
                    <tr class="top-0 sticky text-gray-600 text-left text-xs md:text-xxs xxl:text-xl">
                        <th class="">{{ $componentType == 'trades' ? 'Deal made at' : 'Listing placed at' }}</th>
                        @if($componentType == 'trades')
                            <th>Trade type</th>
                        @endif
                        <th class="">Hydrogen type</th>
                        <th class="">Total volume</th>
                        @if($componentType == 'trades')
                            <th>Total price</th>
                            <th>Duration</th>
                        @endif
                        <th class="opacity-0">Info</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($tradeEntries as $tradeEntry)
                        <tr class="text-xs xl:text-sm xxl:text-2xl top-0">
                            <td class="py-2 md:py-1 sm:py-1 xxl:py-4">
                                {{ Carbon\Carbon::parse($componentType == 'trades' ? $tradeEntry->deal_made_at : $tradeEntry->created_at)->toDateString() }}
                            </td>
                            @if($componentType == 'trades')
                                <td class="py-2 md:py-1 sm:py-1 xxl:py-4">
                                    {{ $tradeEntry->trade_type }}
                                </td>
                            @endif
                            <td class="flex items-center py-2 md:py-1 sm:py-1 xxl:py-4">
                                <svg class="fill-current text-type{{ ucfirst($tradeEntry["hydrogen_type"]) }}-500"
                                     height="24" width="24">
                                    <circle cx="10" cy="12" r="4"/>
                                </svg>
                                {{ $tradeEntry->hydrogen_type }}
                            </td>
                            <td class="py-2 md:py-1 sm:py-1 xxl:py-4">
                                {{ number_format($tradeEntry->total_volume, 0, '.', ' ') }} units
                            </td>
                            @if($componentType == 'trades')
                                <td class="py-2 md:py-1 sm:py-1 xxl:py-4">
                                    € {{ number_format($tradeEntry->total_price, 0, '.', ' ') }}
                                </td>
                                <td class="py-2 md:py-1 sm:py-1 xxl:py-4">
                                    {{ $tradeEntry->end }}
                                </td>
                            @endif
                            <td class="py-2 md:py-1 sm:py-1 xxl:py-4">
                                <button class="font-semibold underline" wire:click="openTradeEntry({{ $tradeEntry }})">Info</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!--Pagination-->
    @if (!(count($tradeEntries) < $itemsPerPage) || (count($tradeEntries) < $itemsPerPage && $page != 1))
    <div class="flex flex-none w-full flex-row pt-2">
        <ul class="w-full flex justify-between text-xs md:text-xxs">
            <div class="flex justify-start items-end gap-4">
                <li class="xxl:text-2xl">
                    Jump to Page

                    <select class="cursor-pointer" title="" wire:click="getTradeEntries" wire:model="page" wire:change="getTradeEntries">
                        @for($i = 1; $i <= $paginator['last_page']; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </li>
            </div>

            <div class="flex justify-center items-end text-xs xxl:text-3xl gap-10">
                <li style="display: {{ $page == 1 ? 'none' : 'block'}}">
                    <button class="font-normal hover:font-bold"
                            wire:click="applyPagination('page_previous', {{ $page-1 }})">
                        Previous
                    </button>
                </li>

                <li style="display: {{ $page == $paginator['last_page'] ? 'none' : 'block'}}">
                    <button class="font-normal hover:font-bold"
                            wire:click="applyPagination('page_next', {{ $page+1 }})">
                        Next
                    </button>
                </li>
            </div>

            <div class="flex flex-row justify-end items-end gap-4">
                <li class="xxl:text-2xl">
                    Items per Page

                    <select class="cursor-pointer" title="" wire:model="itemsPerPage"
                            wire:change="applyPagination('', {{ $page }})">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </li>
            </div>
        </ul>
    </div>
    @endif
</div>
