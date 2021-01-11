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

        // Build the chart data
        $this->buildChart($period, $chartType);

        // Determine the impact
        $tradePeriod = CarbonPeriod::create(Carbon::now(), $trade->end_raw);

        foreach ($tradePeriod as $index => $day) {
            // Set the impact
            $impact = (int)$trade->getUnitsAtCarbonDate($day);

            if ($trade->trade_type == "request") {
                $impact = -$impact;
            }

            $this->chartData[$chartType]['impact'][] = $impact;

            // Update the min and max values
            $totalLoad = $this->chartData[$chartType]['totalLoad'][$index];
            $bounds = null;

            if ($impact > 0) {
                // Update max
                if ($totalLoad > 0 && $totalLoad + $impact > $this->chartData[$chartType]['max']) {
                    $bounds = $this->modifyBoundaries($this->chartData[$chartType]['min'], $totalLoad + $impact);
                }
                else if($impact > $this->chartData[$chartType]['max']) {
                    $bounds = $this->modifyBoundaries($this->chartData[$chartType]['min'], $impact);
                }

                if ($bounds) {
                    $this->chartData[$chartType]['max'] = $bounds[1];
                }
            }
            else if ($impact < 0) {
                // Update min
                if ($totalLoad < 0 && $totalLoad + $impact < $this->chartData[$chartType]['min']) {
                    $bounds = $this->modifyBoundaries($totalLoad + $impact, $this->chartData[$chartType]['max']);
                }
                else if ($impact < $this->chartData[$chartType]['min']) {
                    $bounds = $this->modifyBoundaries($impact, $this->chartData[$chartType]['max']);
                }

                if ($bounds) {
                    $this->chartData[$chartType]['min'] = $bounds[0];
                }
            }
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
