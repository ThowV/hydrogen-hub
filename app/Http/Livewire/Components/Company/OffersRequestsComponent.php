<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class OffersRequestsComponent extends Component
{
    public $listings;

    public function getListings()
    {$this->listings = auth()->user()->company->listings;
    }

    public function openListing(Trade $trade)
    {$this->emit('openTradeAndListingInfoModal', $trade);
    }

    public function getDate($listingPlacedAt) {return Carbon::parse($listingPlacedAt)->toDateString();
    }

    public function mount(){$this->getListings();
    }

    public function render()
    {
        return view('livewire.components.company.offers-requests-component');
    }
}
