<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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

    public $filter = [
        'hydrogen_type'     => [],
        'units_per_hour'    => [0, 0],
        'duration'          => [0, 0],
        'total_volume'      => [0, 0],
        'price_per_unit'    => [0, 0],
        'mix_co2'           => [0, 0],
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

    public function toggleCreateModal()
    {
        $this->isCreateModalOpen = !$this->isCreateModalOpen;
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
        $this->toggleCreateModal();

        // Update trades since we added a new one
        $this->updateTrades();
    }

    public function updateTrades($setup = false)
    {
        // Determine the bounds and filters
        if ($setup)
        {
            $this->determineStartingFilters();
        }

        // Apply filters and pagination
        $trades = $this->getFilteredListings();

        $trades = $trades->paginate($this->itemsPerPage, ['*'], 'page', $this->page);

        $this->totalItems = $trades->total();
        $this->paginator = $trades->toArray();
        $this->trades = $trades->items();
    }

    private function determineStartingFilters()
    {
        // Determine bounds for database fields
        foreach ($this->filter as $key => $value) {
            // Skip calculated fields
            if ($key == 'total_volume')
            {
                continue;
            }

            $this->filter[$key] = [Trade::min($key), Trade::max($key)];
        }

        // Determine bounds for calculated fields
        $this->filter['total_volume'] = [
            Trade::min('units_per_hour') * Trade::min('duration'),
            Trade::max('units_per_hour') * Trade::max('duration')
        ];
    }

    private function getFilteredListings()
    {
        // Filter: Units per hour
        $trades = Trade::whereBetween('units_per_hour', $this->filter['units_per_hour']);

        // Filter: Duration
        $trades = $trades->whereBetween('duration', $this->filter['duration']);

        // Filter: Total volume
        $trades = $trades
            ->whereRaw('duration * units_per_hour >= ?', $this->filter['total_volume'][0])
            ->whereRaw('duration * units_per_hour <= ?', $this->filter['total_volume'][1]);

        // Filter: Price per unit
        $trades = $trades->whereBetween('price_per_unit', $this->filter['price_per_unit']);

        // Filter: mix CO2
        $trades = $trades->whereBetween('mix_co2', $this->filter['mix_co2']);

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
