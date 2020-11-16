<?php

namespace App\Http\Livewire;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Livewire\Component;

class MarketComponent extends Component
{
    public $trade_type;
    public $hydrogen_type;
    public $units_per_hour;
    public $duration;
    public $price_per_unit;
    public $mix_co2;
    public $expires_at;

    // Default select does not work with livewire at the moment:
    public $duration_type = "day";
    public $expires_at_type = "day";

    public $isCreateModalOpen = false;
    public $isRespondModalOpen = false;

    public $trades;
    public $trade;

    protected $rules = [
        'trade_type' =>     'required',
        'hydrogen_type' =>  'required',
        'units_per_hour' => 'required|numeric|min:0|max:1000000',
        'duration' =>       'required|numeric',
        'price_per_unit' => 'required|numeric|min:0|max:1000000',
        'mix_co2' =>        'required|numeric|min:0|max:1000000',
        'expires_at' =>     'required|numeric',
    ];

    public function submit()
    {
        $data = $this->validate();

        // Add owner_id value to data
        $data['owner_id'] = auth()->id();

        // Modify duration data
        $data['duration'] = $data['duration'] . ' ' . $this->duration_type . ($data['duration'] > 1 ? 's' : '');

        // Modify expires at data
        $data['expires_at'] = now()->add($data['expires_at'], $this->expires_at_type);

        // Create trade
        Trade::create($data);

        // Close create modal
        $this->closeCreateModal();

        // Update trades since we added a new one
        $this->updateTrades();
    }

    public function mount()
    {
        $this->updateTrades();
    }

    public function render()
    {
        return view('livewire.market-component')->extends('layouts.app');
    }

    public function openCreateModal()
    {
        $this->isCreateModalOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
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

    private function updateTrades()
    {
        $this->trades = Trade::latest()->limit(10)->get()->toArray();
    }
}
