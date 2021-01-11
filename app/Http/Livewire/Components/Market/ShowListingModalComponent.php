<?php

namespace App\Http\Livewire\Components\Market;

use App\Http\Livewire\Components\Company\Traits\PortfolioChartBuilderTrait;
use App\Models\Trade;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowListingModalComponent extends Component
{
    use PortfolioChartBuilderTrait;

    public $isOpen = false;
    public $confirmationStage = false;
    public $chartData = [];
    public $trade;

    protected $listeners = ['openRespondModal' => 'openListing'];

    public function openListing(Trade $trade)
    {
        $this->trade = $trade;
        $this->toggleModal();

        // Get the chart types
        $chartType = $trade->hydrogen_type;

        // Determine the period
        $period = CarbonPeriod::create(Carbon::now(), Carbon::now()->addDays(6));

        $this->buildChart($period, $chartType);
        $this->emit('listingOpened', $this->chartData[$chartType]);
    }

    public function toggleConfirmationStage()
    {
        $this->confirmationStage = !$this->confirmationStage;
    }

    public function makeTrade(Trade $trade)
    {
        // Update trade to create deal
        $trade->responder_id = auth()->id();
        $trade->deal_made_at = now();

        // Finalize
        $trade->save();
        $this->emit('tradeMade');

        $this->toggleModal();
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.market.show-listing-modal-component');
    }
}
