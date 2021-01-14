<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class ChartExpandedInfoComponent extends Component
{
    public $datetime = '';
    public $demand = 0;
    public $store = 0;
    public $produce = 0;
    public $totalLoad = 0;
    public $sold = 0;
    public $bought = 0;
    public $position = 0;
    public $runningTradesBought = [];
    public $runningTradesSold = [];

    protected $listeners = ['showChartPointInfo' => 'showChartPointInfo'];

    public function showChartPointInfo($xIndex, $chartData) {
        // Set the pre-calculated data values
        $this->datetime = $chartData['labels'][$xIndex];
        $this->demand = $chartData['demand'][$xIndex];
        $this->store = $chartData['store'][$xIndex];
        $this->produce = $chartData['produce'][$xIndex];
        $this->totalLoad = $chartData['totalLoad'][$xIndex];
        $this->sold = $chartData['sold'][$xIndex];
        $this->bought = $chartData['bought'][$xIndex];

        // Set the to be calculated data values
        if ($this->demand != 0 && $this->totalLoad != 0) {
            if ($this->demand > $this->totalLoad) {
                $this->position = 100 - round(($this->totalLoad / $this->demand) * 100);
            }
            else {
                $this->position = 100 + round(($this->demand / $this->totalLoad) * 100);
            }
        }

        // Get the running contracts
        $start = Carbon::create(str_replace('-', '', $this->datetime));
        $this->runningTradesBought = auth()->user()->company->getBoughtTradesAfterCarbonDate($start)->where('hydrogen_type', $chartData['hydrogenType']);
        $this->runningTradesSold = auth()->user()->company->getSoldTradesAfterCarbonDate($start)->where('hydrogen_type', $chartData['hydrogenType']);
    }

    public function openTradeEntry(Trade $trade)
    {
        $this->emit('openTradeAndListingInfoModal', $trade);
    }

    public function render()
    {
        return view('livewire.components.company.chart-expanded-info-component');
    }
}
