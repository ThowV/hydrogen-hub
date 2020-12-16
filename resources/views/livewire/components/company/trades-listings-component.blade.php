<div class="w-full h-full">
    <div class="w-full h-12 xxl:h-24">
        <h2 class="text-base xxl:text-3xl font-bold">{{ $componentType == 'trades' ? 'Trades' : 'Offers & requests' }}</h2>
    </div>

    @if (count($tradeEntries) == 0) <!--empty() does not work here. Investigation needed-->
        <h2 class="text-sm text-center">There are no {{ $componentType == 'trades' ? 'trades' : 'offers or requests' }} made yet.</h2>
    @else
        <table class="w-full">
            <thead>
            <tr class="border-b-2 text-gray-600 text-left text-xs xxl:text-xl">
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
            </tr>
            </thead>

            <tbody>
            @foreach($tradeEntries as $tradeEntry)
                <tr class="text-xs xl:text-sm xxl:text-2xl">
                    <td class="py-2 xxl:py-4">
                        {{ $this->getDate($componentType == 'trades' ? $tradeEntry->deal_made_at : $tradeEntry->created_at) }}
                    </td>
                    @if($componentType == 'trades')
                        <td class="py-3 xxl:py-5">
                            {{ $tradeEntry->trade_type }}
                        </td>
                    @endif
                    <td class="py-2 xxl:py-4">
                        {{ $tradeEntry->hydrogen_type }}
                    </td>
                    <td class="py-2 xxl:py-4">
                        {{ number_format($tradeEntry->total_volume, 0, '.', ' ') }} units
                    </td>
                    @if($componentType == 'trades')
                        <td class="py-3 xxl:py-5">
                            € {{ number_format($tradeEntry->total_price, 0, '.', ' ') }}
                        </td>
                        <td class="py-3 xxl:py-5">
                            {{ $tradeEntry->end }}
                        </td>
                    @endif
                    <td class="py-2 xxl:py-4">
                        <button class="font-semibold" wire:click="openTradeEntry({{ $tradeEntry }})">Info</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

<!--Pagination-->
    @if (!(count($tradeEntries) < $itemsPerPage) || (count($tradeEntries) < $itemsPerPage && $page != 1))
        <div class="flex w-full h-14 md:h-32 xl:h-18 xxl:h-32 flex flex-row pt-5">
            <ul class="w-full h-full grid grid-cols-3 grid-rows-1">
                <div class="col-start-2 flex justify-center items-end xxl:text-3xl gap-10">
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

                <div class="col-start-3 flex flex-row justify-end items-end gap-4">
                    <li class="text-xs xxl:text-2xl">
                        Jump to Page

                        <select class="cursor-pointer" title="" wire:click="getTradeEntries" wire:model="page" wire:change="getTradeEntries">
                            @for($i = 1; $i <= $paginator['last_page']; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </li>

                    <li class="text-xs xxl:text-2xl">
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
