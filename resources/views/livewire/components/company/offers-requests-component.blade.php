<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Offers & Requests</h2>
    </div>

    @if (count($listings) == 0) <!--empty() does not work here. Investigation needed-->
        <h2 class="grid items-center text-xl xxl:text-3xl">There are no offers or requests made yet.</h2>
    @else
            <table class="w-full">
                <thead>
                <tr class="border-b-2 text-gray-600">
                    <th class="text-left sm:text-xs text-sm xxl:text-xl">Listing placed at</th>
                    <th class="text-left sm:text-xs text-sm xxl:text-xl">Hydrogen type</th>
                    <th class="text-left sm:text-xs text-sm xxl:text-xl">Total volume</th>
                </tr>
                </thead>

                <tbody>
                @foreach($listings as $listing)
                    <tr>
                        <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                            {{ $this->getDate($listing['created_at']) }}
                        </td>
                        <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                            {{ $listing['hydrogen_type'] }}
                        </td>
                        <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                            {{ $listing['total_volume'] }}
                        </td>
                        <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">
                            <button wire:click="openListing({{ $listing }})">Info</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    @endif
</div>
