<div>
    <h1 class="text-xl">Trades</h1>

    @foreach($trades as $trade)
        <div>
            <span>{{ $trade['hydrogen_type'] }}</span>
            <span>{{ $trade['total_volume'] }}</span>
            <span>{{ $trade['duration'] }}</span>
            <span>{{ $trade['trade_type'] }}</span>
            <span>{{ $this->getUserName($trade['responder_id']) }}</span>
            <a href="#">Info</a>
        </div>
    @endforeach
</div>
