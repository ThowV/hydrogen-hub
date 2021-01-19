<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListingsComponent extends Component
{
    const EXCLUDED_FILTERS = ['hydrogen_type', 'trade_type', 'total_volume'];

    protected $listeners = ['listingCreated' => 'updateTrades', 'tradeMade' => 'updateTrades'];

    public $paginator = [];
    public $page = 1;
    public $itemsPerPage = 10;
    public $totalItems = 0;
    public $tradesColl;

    public $filter = [
        'hydrogen_type' => ['green', 'blue', 'grey', 'mix'],
        'units_per_hour' => [0, 0],
        'duration' => [0, 0],
        'total_volume' => [0, 0],
        'price_per_unit' => [0, 0],
        'mix_co2' => [0, 0],
        'trade_type' => ['offer', 'request'],
    ];

    public $sort = [
        'hydrogen_type'     => ['Hydrogen type', ''],
        'units_per_hour'    => ['Units per hour', ''],
        'duration'          => ['Duration', ''],
        'total_volume'      => ['Total volume', ''],
        'price_per_unit'    => ['Price per unit', ''],
        'mix_co2'           => ['Mix % CO2', ''],
        'trade_type'        => ['Type', ''],
    ];

    public function determineStartingFilters()
    {
        // Determine bounds for database fields
        foreach (collect($this->filter)->except(self::EXCLUDED_FILTERS) as $key => $value) {
            $this->filter[$key] = [Trade::min($key), Trade::max($key)];
        }

        // Determine bounds for calculated fields
        $this->filter['total_volume'] = [
            Trade::min('units_per_hour') * Trade::min('duration'),
            Trade::max('units_per_hour') * Trade::max('duration'),
        ];
    }

    public function resetFilters() {
        $this->determineStartingFilters();

        $filters = $this->filter;
        unset($filters['hydrogen_type']);
        unset($filters['trade_type']);

        $this->emit('resetFilters', $filters);
    }

    private function getFilteredSortedListings()
    {
        $this->enableCheckboxes();
        $trades = $this->getFilteredTrades();
        $this->applySorting($trades);

        return $trades;
    }

    protected function applySorting($trades)
    {
        $sorted = false;

        foreach ($this->sort as $key => $value) {
            if ($value[1] != '') {
                $sorted = true;

                if ($key != 'total_volume') {
                    $trades->orderBy($key, $value[1]);
                }
                else {
                    $trades->orderBy(DB::raw('duration * units_per_hour'), $value[1]);
                }
            }
        }

        if (!$sorted) {
            $trades->orderBy('created_at', 'DESC');
        }
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

        //$trades->where('owner_id','!=', auth()->user()->id);
        $trades->whereNotIn('owner_id', auth()->user()->company->employees->pluck('id'));

        return $trades;
    }

    public function updatePaginator($trades = null)
    {
        if (!$trades) {
            $trades = $this->getFilteredSortedListings();
            $trades = $trades->paginate($this->itemsPerPage, ['*'], 'page', $this->page);
        }

        $this->totalItems = $trades->total();
        $this->paginator = $trades->toArray();
        $this->tradesColl = $trades->items();
    }

    public function applyPagination($action, $value)
    {
        // Apply pagination
        if ($action == 'page_previous' && $this->page > 1) {
            $this->page -= 1;
        } elseif ($action == 'page_next') {
            $this->page += 1;
        } elseif ($action == 'page') {
            $this->page = $value;
        }

        // Check if pagination is out of bounds
        if (($this->page - 1) * $this->itemsPerPage > $this->totalItems) {
            $this->page = 1;
        }

        // Finalize
        $this->updateTrades();
    }

    public function openCreateModal()
    {
        $this->emit("openCreateModal");
    }

    public function openListing(Trade $trade)
    {
        $this->emit('openRespondModal', $trade);
    }

    public function updateTrades($setup = false)
    {
        // Determine the bounds and filters
        if ($setup) {
            $this->determineStartingFilters();
        }

        // Get filtered and sorted listings
        $trades = $this->getFilteredSortedListings();

        // Paginate
        $trades = $trades->paginate($this->itemsPerPage, ['*'], 'page', $this->page);

        // Update paginator
        $this->updatePaginator($trades);
    }

    public function getTrade($trade_id)
    {
        return Trade::where('id', $trade_id)->get();
    }

    public function getReadableDate(Trade $trade)
    {
        return $trade->expires_at->toDateString();
    }

    public function mount()
    {
        $this->updateTrades(true);
    }

    public function render()
    {
        return view('livewire.components.market.listings-component', [
            'trades' => $this->getFilteredSortedListings()->paginate($this->itemsPerPage, ['*'], 'page', $this->page)->items(),
        ]);
    }
}
