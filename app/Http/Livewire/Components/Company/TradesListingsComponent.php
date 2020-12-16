<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class TradesListingsComponent extends Component
{
    public $componentType;
    public $tradeEntries = [];

    public $paginator = [];
    public $page = 1;
    public $itemsPerPage = 5;
    public $totalItems = 0;

    public function getTradeEntries()
    {
        $tradeEntriesPaginator = null;

        if ($this->componentType == 'listings') {
            // Paginate querybuilder
            $tradeEntriesPaginator = auth()->user()->company->listings()->paginate($this->itemsPerPage, ['*'], 'page', $this->page);
        }
        elseif ($this->componentType == 'trades') {
            // Paginatie collection using custom service
            $tradeEntriesPaginator = auth()->user()->company->trades->paginate($this->itemsPerPage, $this->page);
        }

        if ($tradeEntriesPaginator) {
            $this->totalItems = $tradeEntriesPaginator->total();
            $this->paginator = $tradeEntriesPaginator->toArray();
            $this->tradeEntries = $tradeEntriesPaginator->items();
        }
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
        $this->getTradeEntries();
    }

    public function openTradeEntry(Trade $trade)
    {
        $this->emit('openTradeAndListingInfoModal', $trade);
    }

    public function getDate($listingPlacedAt)
    {
        return Carbon::parse($listingPlacedAt)->toDateString();
    }

    public function mount()
    {
        $this->getTradeEntries();
    }

    public function render()
    {
        return view('livewire.components.company.trades-listings-component');
    }
}
