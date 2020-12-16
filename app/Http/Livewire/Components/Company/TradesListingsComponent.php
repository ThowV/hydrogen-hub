<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class TradesListingsComponent extends Component
{
    public $componentType;
    public $tradeEntries;

    public function getTradeEntries()
    {
        if ($this->componentType == 'listings') {
            $this->tradeEntries = auth()->user()->company->listings;
        }
        elseif ($this->componentType == 'trades') {
            $this->tradeEntries = auth()->user()->company->trades;
        }
    }

    public function openTradeEntry(Trade $trade)
    {
        $this->emit('openTradeAndListingInfoModal', $trade);
    }

    public function getDate($listingPlacedAt)
    {
        return Carbon::parse($listingPlacedAt)->toDateString();
    }

    public function mount()
    {
        $this->getTradeEntries();
    }

    public function render()
    {
        return view('livewire.components.company.trades-listings-component');
    }
}
