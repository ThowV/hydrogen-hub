<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowListingModalComponent extends Component
{

    public $isOpen = false;
    public $confirmationStage = false;

    public $trade;

    protected $listeners = ['openRespondModal' => 'openListing'];

    public function openListing(Trade $trade)
    {
        $this->trade = $trade;
        $this->toggleModal();
    }

    public function toggleConfirmationStage()
    {
        $this->confirmationStage = !$this->confirmationStage;
    }

    public function makeTrade(Trade $trade)
    {
        // Update trade to create deal
        $trade->responder_id = auth()->id();
        $trade->deal_made_at = now();

        // Finalize
        $trade->save();
        $this->emit('tradeMade');

        $this->toggleModal();
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.market.show-listing-modal-component');
    }
}
