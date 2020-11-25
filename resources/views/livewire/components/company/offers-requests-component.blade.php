<div>
    <h1 class="text-xl">Offers & requests</h1>

    @if (count($listings) == 0) <!--empty() does not work here. Investigation needed-->
        <span>There are no offers or requests made yet.</span>
    @else
        @foreach($listings as $listing)
            <div>
                <span>{{ $listing['end'] }}</span> |
                <span>{{ $listing['hydrogen_type'] }}</span> |
                <span>{{ $listing['total_volume'] }}</span> |
                <a href="#">Info</a>
            </div>
        @endforeach
    @endif
</div>
