<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\User;
use Livewire\Component;

class OffersRequestsComponent extends Component
{
    public $listings;

    public function getListings()
    {
        $this->listings = auth()->user()->company->listings;

        foreach ($this->listings as $listing) {

        }
    }

    public function mount()
    {
        $this->getListings();
    }

    public function render()
    {
        return view('livewire.components.company.offers-requests-component');
    }
}
