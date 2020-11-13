<?php

namespace App\Http\Livewire;

use App\Models\Trade;
use Livewire\Component;

class MarketComponent extends Component
{
    public $trade_type, $hydrogen_type, $units_per_hour, $duration, $price_per_unit, $mix_co2, $expires_at;

    // Default select does not work with livewire at the moment:
    public $duration_type = "days";
    public $expires_at_type = "days";

    public $isCreateModalOpen = false;

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
        $data['duration'] = now()->add($data['duration'], $this->duration_type);

        // Modify expires at data
        $data['expires_at'] = now()->add($data['expires_at'], $this->expires_at_type);

        // Create trade
        Trade::create($data);

        // Close create modal
        $this->closeCreateModal();
    }

    public function render()
    {
        $trades = Trade::latest()->paginate(10);

        return view('livewire.market-component', ['trades' => $trades])->extends('layouts.app');;
    }

    public function openCreateModal()
    {
        $this->isCreateModalOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
    }
}
