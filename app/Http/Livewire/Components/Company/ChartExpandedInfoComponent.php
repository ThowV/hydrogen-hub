<?php

namespace App\Http\Livewire\Components\Company;

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
                //dd($this->totalLoad, $this->demand, $this->totalLoad / $this->demand);
            }
            else {
                $this->position = 100 + round(($this->demand / $this->totalLoad) * 100);
                //dd($this->demand, $this->totalLoad, $this->demand / $this->totalLoad);
            }

            //dd(($this->demand / $this->totalLoad) * 100);
        }

    }

    public function render()
    {
        return view('livewire.components.company.chart-expanded-info-component');
    }
}
