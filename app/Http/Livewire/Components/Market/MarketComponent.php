<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
    public $itemsPerPage = 15;
    public $totalItems = 0;

    public $bounds = [
        'units_per_hour_min'    => 0,
        'units_per_hour_max'    => 0,
        'duration_min'          => 0,
        'duration_max'          => 0,
        'total_volume_min'      => 0,
        'total_volume_max'      => 0,
        'price_per_unit_min'    => 0,
        'price_per_unit_max'    => 0,
        'mix_co2_min'           => 0,
        'mix_co2_max'           => 0,
    ];

    public $filter = [
        'hydrogen_type'     => [],
        'units_per_hour'    => '',
        'duration'          => '',
        'total_volume'      => '',
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
        // Determine the bounds and filters
        if ($setup)
        {
            $this->determineBounds();
            $this->determineStartingFilters();
        }

        // Apply filters and pagination
        $trades = $this->getFilteredListings();

        $trades = $trades->paginate($this->itemsPerPage, ['*'], 'page', $this->page);

        $this->totalItems = $trades->total();
        $this->paginator = $trades->toArray();
        $this->trades = $trades->items();
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

    private function getFilteredListings()
    {
        // Filter: Units per hour
        $trades = Trade::where('units_per_hour', '<', $this->filter['units_per_hour']);

        // Filter: Duration
        $trades = $trades->where('duration', '<', $this->filter['duration']);

        // Filter: Total volume
        $trades = $trades->whereRaw('duration * units_per_hour < ?', $this->filter['total_volume']);

        // Filter: Price per unit
        $trades = $trades->where('price_per_unit', '<', $this->filter['price_per_unit']);

        // Filter: mix CO2
        $trades = $trades->where('mix_co2', '<', $this->filter['mix_co2']);

        // Filter: Hydrogen types
        if (!empty($this->filter['hydrogen_type']))
        {
            $trades = $trades->whereIn('hydrogen_type', $this->filter['hydrogen_type']);
        }

        // Filter: Trade types
        if (!empty($this->filter['trade_type']))
        {
            $trades = $trades->whereIn('trade_type', $this->filter['trade_type']);
        }

        return $trades;
    }

    public function applyPagination($action, $value)
    {
        // Apply pagination
        if ($action == 'page_previous' && $this->page > 1)
        {
            $this->page -= 1;
        }
        else if ($action == 'page_next')
        {
            $this->page += 1;
        }
        else if ($action == 'page')
        {
            $this->page = $value;
        }

        // Check if pagination is out of bounds
        if ($this->page * $this->itemsPerPage > $this->totalItems)
        {
            $this->page = 1;
        }

        // Finalize
        $this->updateTrades();
    }
}
