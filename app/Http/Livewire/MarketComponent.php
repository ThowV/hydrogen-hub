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
        'hydrogen_type' =>   'required',
        'units_per_hour' =>   'required|numeric|min:0|max:1000000',
        'duration' =>       'required|numeric',
        'price_per_unit' =>   'required|numeric|min:0|max:1000000',
        'mix_co2' =>         'required|numeric|min:0|max:1000000',
        'expires_at' =>      'required|numeric',
    ];

    public function submit()
    {
        $data = $this->validate();

        // Add owner_id value to data
        $data['owner_id'] = 10;

        // Modify duration data
        if ($this->duration_type === "days") {
            $data['duration'] = now()->addDays($data['duration']);
        }
        elseif ($this->duration_type === "weeks") {
            $data['duration'] = now()->addWeeks($data['duration']);
        }
        elseif ($this->duration_type === "months") {
            $data['duration'] = now()->addMonths($data['duration']);
        }

        // Modify expires at data
        if ($this->expires_at_type === "days") {
            $data['expires_at'] = now()->addDays($data['expires_at']);
        }
        elseif ($this->expires_at_type === "weeks") {
            $data['expires_at'] = now()->addWeeks($data['expires_at']);
        }
        elseif ($this->expires_at_type === "months") {
            $data['expires_at'] = now()->addMonths($data['expires_at']);
        }

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
