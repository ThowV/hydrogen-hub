<div>
    <h1 class="text-xl">Offers & requests</h1>

    @foreach($listings as $listing)
        <div>
            <span>{{ $listing['hydrogen_type'] }}</span>
            <span>{{ $listing['total_volume'] }}</span>
            <a href="#">Info</a>
        </div>
    @endforeach
</div>
