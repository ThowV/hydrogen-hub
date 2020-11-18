<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Livewire\Component;

class MarketComponent extends Component
{
    public $isCreateModalOpen = false;
    public $isRespondModalOpen = false;

    public $trades;
    public $trade;

    protected $listeners = ['listingCreated' => 'listingCreated'];

    public function mount()
    {
        $this->updateTrades();
    }

    public function render()
    {
        return view('livewire.components.market.market-component')->extends('layouts.app');
    }

    public function openCreateModal()
    {
        $this->isCreateModalOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
    }

    public function listingCreated()
    {
        // Close create modal
        $this->closeCreateModal();

        // Update trades since we added a new one
        $this->updateTrades();
    }

    public function openRespondModal(Trade $trade)
    {
        // Turn trade object into an array
        $trade = $trade->toArray();

        // Modify expires at data to create expires in value
        $expiresIn = (new Carbon($trade['expires_at']))->diff(now());
        $expiresIn = array("days"=>$expiresIn->d, "hours"=>$expiresIn->h, "minutes"=>$expiresIn->i);
        $trade['expires_in'] = $expiresIn;

        // Finalize
        $this->trade = $trade;
        $this->isRespondModalOpen = true;
    }

    public function closeRespondModal()
    {
        $this->isRespondModalOpen = false;
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

    private function updateTrades()
    {
        $this->trades = Trade::latest()->limit(10)->get()->toArray();
    }
}
