<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Boolean;

class MarketComponent extends Component
{
    public $isCreateModalOpen = false;
    public $isRespondModalOpen = false;

    public $trades;
    public $trade;

    public $paginator = [];
    public $page = 1;
    public $itemsPerPage = 5;

    public $bounds = [
        'units_per_hour_min'    => 0,
        'units_per_hour_max'    => 0,
        'duration_min'          => 0,
        'duration_max'          => 0,
        //'total_volume_min'    => 0,
        //'total_volume_max'    => 0,
        'price_per_unit_min'    => 0,
        'price_per_unit_max'    => 0,
        'mix_co2_min'           => 0,
        'mix_co2_max'           => 0,
    ];

    public $filter = [
        'hydrogen_type'     => [],
        'units_per_hour'    => '',
        'duration'          => '',
        //'total_volume'    => '',
        'price_per_unit'    => '',
        'mix_co2'           => '',
        'trade_type'        => [],
    ];

    protected $listeners = ['listingCreated' => 'listingCreated'];

    public function mount()
    {
        $this->updateTrades(true);
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

    public function openRespondModal(Trade $trade)
    {
        $this->trade = $trade;
        $this->isRespondModalOpen = true;
        $this->emit('listingSelected', $trade);
    }

    public function closeRespondModal()
    {
        $this->isRespondModalOpen = false;
    }

    public function listingCreated()
    {
        // Close create modal
        $this->closeCreateModal();

        // Update trades since we added a new one
        $this->updateTrades();
    }

    public function updateTrades($setup = false)
    {
        if ($setup)
        {
            $this->determineBounds();
            $this->determineStartingFilters();
        }

        $this->trades = Trade::limit(10);

        $this->applyFilters();

        $this->trades = $this->trades->get()->toArray();
    }

    private function determineBounds()
    {
        // Units per hour
        $this->bounds['units_per_hour_min'] = Trade::min('units_per_hour');
        $this->bounds['units_per_hour_max'] = Trade::max('units_per_hour');

        // Duration
        $this->bounds['duration_min'] = Trade::min('duration');
        $this->bounds['duration_max'] = Trade::max('duration');

        // Total volume
        $this->bounds['total_volume_min'] = Trade::min('units_per_hour') * Trade::min('duration');
        $this->bounds['total_volume_max'] = Trade::max('units_per_hour') * Trade::max('duration');

        // Price per unit
        $this->bounds['price_per_unit_min'] = Trade::min('price_per_unit');
        $this->bounds['price_per_unit_max'] = Trade::max('price_per_unit');

        // Mix CO2
        $this->bounds['mix_co2_min'] = Trade::min('mix_co2');
        $this->bounds['mix_co2_max'] = Trade::max('mix_co2');
    }

    private function determineStartingFilters()
    {
        $this->filter = [
            'hydrogen_type'     => [],
            //'units_per_hour'  => round(($this->bounds['units_per_hour_min'] + $this->bounds['units_per_hour_max']) / 2),
            'units_per_hour'    => $this->bounds['units_per_hour_max'],
            //'duration'        => round(($this->bounds['duration_min'] + $this->bounds['duration_max']) / 2),
            'duration'          => $this->bounds['duration_max'],
            //'total_volume'    => round(($this->bounds['total_volume_min'] + $this->bounds['total_volume_max']) / 2),
            'total_volume'      => $this->bounds['total_volume_max'],
            //'price_per_unit'  => round(($this->bounds['price_per_unit_min'] + $this->bounds['price_per_unit_max']) / 2),
            'price_per_unit'    => $this->bounds['price_per_unit_max'],
            //'mix_co2'         => round(($this->bounds['mix_co2_min'] + $this->bounds['mix_co2_max']) / 2),
            'mix_co2'           => $this->bounds['mix_co2_max'],
            'trade_type'        => [],
        ];
    }

    private function applyFilters()
    {
        if (!empty($this->filter['hydrogen_type']))
        {
            $this->trades = $this->trades->whereIn('hydrogen_type', $this->filter['hydrogen_type']);
        }

        if (!empty($this->filter['units_per_hour']))
        {
            $this->trades = $this->trades->where('units_per_hour', '<', $this->filter['units_per_hour']);
        }

        if (!empty($this->filter['duration']))
        {
            $this->trades = $this->trades->where('duration', '<', $this->filter['duration']);
        }

        if (!empty($this->filter['total_volume']))
        {
            $this->trades->whereRaw('duration * units_per_hour < ?', $this->filter['total_volume']);
        }

        if (!empty($this->filter['price_per_unit']))
        {
            $this->trades = $this->trades->where('price_per_unit', '<', $this->filter['price_per_unit']);
        }

        if (!empty($this->filter['trade_type']))
        {
            $this->trades = $this->trades->whereIn('trade_type', $this->filter['trade_type']);
        }
    }
}
