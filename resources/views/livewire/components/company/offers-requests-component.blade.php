<div class="w-full h-full">
    <div class="w-full h-12 xxl:h-24">
        <h2 class="text-base xxl:text-3xl font-bold">Offers & requests</h2>
    </div>

    @if (count($listings) == 0) <!--empty() does not work here. Investigation needed-->
        <h2 class="text-sm text-center">There are no offers or requests made yet.</h2>
    @else
            <table class="w-full">
                <thead>
                <tr class="border-b-2 text-gray-600 text-left text-xs xxl:text-xl">
                    <th class="">Listing placed at</th>
                    <th class="">Hydrogen type</th>
                    <th class="">Total volume</th>
                </tr>
                </thead>

                <tbody>
                @foreach($listings as $listing)
                    <tr class="text-xs xl:text-sm xxl:text-2xl">
                        <td class="py-2 xxl:py-4">
                            {{ $this->getDate($listing['created_at']) }}
                        </td>
                        <td class="py-2 xxl:py-4">
                            {{ $listing['hydrogen_type'] }}
                        </td>
                        <td class="py-2 xxl:py-4">
                            {{ $listing['total_volume'] }}
                        </td>
                        <td class="py-2 xxl:py-4">
                            <button class="font-semibold" wire:click="openListing({{ $listing }})">Info</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    @endif
</div>
