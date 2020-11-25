<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
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
    const  EXCLUDED_FILTERS = ['hydrogen_type', 'trade_type', 'total_volume'];

    public $filter = [
        'hydrogen_type'     => ['green', 'blue', 'grey', 'mix'],
        'units_per_hour'    => [0, 0],
        'duration'          => [0, 0],
        'total_volume'      => [0, 0],
        'price_per_unit'    => [0, 0],
        'mix_co2'           => [0, 0],
        'trade_type'        => ['offer', 'request'],
    ];

    public $sort = [
        'hydrogen_type'     => ['Hydrogen type', ''],
        'units_per_hour'    => ['Units per hour', ''],
        'duration'          => ['Duration', ''],
        'total_volume'      => ['Total volume', ''],
        'price_per_unit'    => ['Price per unit', ''],
        'mix_co2'           => ['Mix % CO2', ''],
        'trade_type'        => ['Trade type', ''],
    ];

    protected $listeners = ['listingCreated' => 'listingCreated', 'tradeMade' => 'tradeMade'];

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

    public function tradeMade()
    {
        // Close respond modal
        $this->closeRespondModal();

        // Update trades since we removed one
        $this->updateTrades();
    }

    public function updateTrades($setup = false)
    {
        // Determine the bounds and filters
        if ($setup) {
            $this->determineStartingFilters();
        }

        // Apply filters and pagination
        $trades = $this->getListings();

        $trades = $trades->paginate($this->itemsPerPage, ['*'], 'page', $this->page);

        $this->totalItems = $trades->total();
        $this->paginator = $trades->toArray();
        $this->trades = $trades->items();
    }

    private function determineStartingFilters()
    {
        // Determine bounds for database fields
        foreach (collect($this->filter)->except(self::EXCLUDED_FILTERS) as $key => $value) {
            $this->filter[$key] = [Trade::min($key), Trade::max($key)];
        }

        // Determine bounds for calculated fields
        $this->filter['total_volume'] = [
            Trade::min('units_per_hour') * Trade::min('duration'),
            Trade::max('units_per_hour') * Trade::max('duration')
        ];
    }

    private function getListings()
    {
        $this->enableCheckboxes();
        $trades = $this->getFilteredTrades();
        $this->applySorting($trades);

        return $trades;
    }

    protected function applySorting(&$trades)
    {
        foreach ($this->sort as $key => $value) {
            if ($value[1] != '') {
                $trades->orderBy($key, $value[1]);
            }
        }
    }

    protected function enableCheckboxes()
    {
        // Make sure that the hydrogen types and trade types checkboxes are not all disabled
        if (empty($this->filter['hydrogen_type'])) {
            $this->filter['hydrogen_type'] = ['green', 'blue', 'grey', 'mix'];
        }

        if (empty($this->filter['trade_type'])) {
            $this->filter['trade_type'] = ['offer', 'request'];
        }
    }

    protected function getFilteredTrades()
    {
        $trades = Trade::whereNull('responder_id');
        foreach ($this->filter as $key => $value) {
            // Skip calculated and enum fields
            if ($key == 'total_volume') {
                // Apply filters for calculated fields
                $trades = $trades
                    ->whereRaw('duration * units_per_hour >= ?', $value[0])
                    ->whereRaw('duration * units_per_hour <= ?', $value[1]);
            } elseif ($key == 'hydrogen_type' || $key == 'trade_type') {
                // Apply filters for enum fields
                $trades = $trades->whereIn($key, $value);
            } else {
                $trades = $trades->whereBetween($key, $value);
            }
        }
        return $trades;
    }

    public function applyPagination($action, $value)
    {
        // Apply pagination
        if ($action == 'page_previous' && $this->page > 1) {
            $this->page -= 1;
        } else {
            if ($action == 'page_next') {
                $this->page += 1;
            } else {
                if ($action == 'page') {
                    $this->page = $value;
                }
            }
        }

        // Check if pagination is out of bounds
        if ($this->page * $this->itemsPerPage > $this->totalItems) {
            $this->page = 1;
        }

        // Finalize
        $this->updateTrades();
    }

    public function changeSort($key)
    {
        if ($this->sort[$key][1] == '') {
            $this->sort[$key][1] = 'ASC';
        } elseif ($this->sort[$key][1] == 'ASC') {
            $this->sort[$key][1] = 'DESC';
        } else {
            $this->sort[$key][1] = '';
        }

        $this->updateTrades();
    }

    public function mount()
    {
        $this->updateTrades(true);
    }

    public function render()
    {
        return view('livewire.components.market.market-component')->extends('layouts.app');
    }
}
