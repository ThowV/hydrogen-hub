<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowListing extends Component
{
    public $trade;

    protected $listeners = ['listingSelected' => 'openListing'];

    public function mount(Trade $trade)
    {
        $this->openListing($trade);
    }

    public function render()
    {
        return view('livewire.components.market.show-listing');
    }

    public function openListing(Trade $trade)
    {
        // Turn trade object into an array
        $this->trade = $trade->toArray();
        $this->trade['total_volume'] = $trade->total_volume;

        // Modify expires at data to create expires in value
        $expiresIn = (new Carbon($this->trade['expires_at']))->diff(now());
        $expiresIn = array('days'=>$expiresIn->d, 'hours'=>$expiresIn->h, 'minutes'=>$expiresIn->i);
        $this->trade['expires_in'] = $expiresIn;
    }

    public function makeTrade(Trade $trade)
    {
        // Update trade to create deal
        $trade->responder_id = auth()->id();
        $trade->deal_made_at = now();

        // Finalize
        $trade->save();
        $this->updateTrades();
    }
}