<?php

namespace App\Http\Livewire\Components\Market;

use App\Http\Livewire\Components\Market\Traits\MarketChartBuilderTrait;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use App\Models\Trade;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowListingModalComponent extends Component
{
    use ChartBuilderTrait, MarketChartBuilderTrait;

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
        $tradePeriod = CarbonPeriod::create(Carbon::now(), $trade->end_raw);

        // Build the chart data
        $this->buildChart($tradePeriod, $chartType);

        // Determine the impact
        foreach ($tradePeriod as $index => $day) {
            // Get the impact
            $impact = (int)$trade->getUnitsAtCarbonDate($day);

            if ($trade->trade_type == "request") {
                $impact = -$impact;
            }

            // Calculate all the values as a result of the impact
            $totalLoad = $this->chartData[$chartType]['totalLoad'][$index];
            $bounds = [$this->chartData[$chartType]['min'], $this->chartData[$chartType]['max']];

            $impactValues = $this->calculateImpactValues($totalLoad, $impact, $bounds);

            $this->chartData[$chartType]['loadLeft'][] = $impactValues['totalLoad'];
            $this->chartData[$chartType]['newTotalLoad'][] = $impactValues['newTotalLoad'];
            $this->chartData[$chartType]['loadRemoved'][] = $impactValues['loadRemoved'];
            $this->chartData[$chartType]['loadAdded'][] = $impactValues['loadAdded'];
            $this->chartData[$chartType]['min'] = $impactValues['min'];
            $this->chartData[$chartType]['max'] = $impactValues['max'];
        }

        // Emit the event to initialize the chart on the front-end
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
