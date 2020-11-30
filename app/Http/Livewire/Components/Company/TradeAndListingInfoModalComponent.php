<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use Livewire\Component;

class TradeAndListingInfoModalComponent extends Component
{
    public $isOpen = false;
    public $trade;

    protected $listeners = ['openTradeAndListingInfoModal' => 'openTrade'];

    public function openTrade(Trade $trade)
    {
        $this->trade = $trade;
        $this->toggleModal();
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }
    public function render()
    {
        return view('livewire.components.company.trade-and-listing-info-modal-component');
    }
}
