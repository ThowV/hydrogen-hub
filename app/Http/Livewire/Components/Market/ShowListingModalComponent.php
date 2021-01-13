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
            // Get the impact
            $impact = (int)$trade->getUnitsAtCarbonDate($day);

            if ($trade->trade_type == "request") {
                $impact = -$impact;
            }

            // Calculate the new load
            $totalLoad = $this->chartData[$chartType]['totalLoad'][$index];
            $loadRemoved = 0;
            $loadAdded = 0;
            $newTotalLoad = $totalLoad + $impact;

            if (($impact >= 0 && $totalLoad < 0) || ($impact < 0 && $totalLoad >= 0)) {
                if (($impact >= 0 && $newTotalLoad < 0) || $impact < 0 && $newTotalLoad >= 0) {
                    $loadRemoved = -$impact; // We are removing all hydrogen
                    $totalLoad = $newTotalLoad; // Our last total load is now what is left
                }
                else if (($impact >= 0 && $newTotalLoad >= 0) || ($impact < 0 && $newTotalLoad < 0)) {
                    $loadRemoved = $totalLoad; // We are removing the entire last total load
                    $totalLoad = 0; // Our last total load is now zero
                    $loadAdded = $newTotalLoad; // We are adding what is left to be added
                }
            }
            else if ($impact >= 0) {
                $loadAdded = $impact; // We are adding all hydrogen
            }
            else if ($impact < 0) {
                $loadRemoved = $impact; // We are removing all hydrogen
            }

            // Set the impact, previous total load and new total load
            $this->chartData[$chartType]['loadLeft'][$index] = $totalLoad;
            $this->chartData[$chartType]['newTotalLoad'][] = $newTotalLoad;
            $this->chartData[$chartType]['loadRemoved'][] = $loadRemoved;
            $this->chartData[$chartType]['loadAdded'][] = $loadAdded;

            // Update the min and max values
            $bounds = [$this->chartData[$chartType]['min'], $this->chartData[$chartType]['max']];

            foreach ([$totalLoad, $loadRemoved, $loadAdded, $newTotalLoad] as $value) {
                if ($value < $bounds[0]) {
                    $bounds = $this->modifyBoundaries($value, $bounds[1]);
                }
                else if ($value > $bounds[1]) {
                    $bounds = $this->modifyBoundaries($bounds[0], $value);
                }

                $this->chartData[$chartType]['min'] = $bounds[0];
                $this->chartData[$chartType]['max'] = $bounds[1];
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
