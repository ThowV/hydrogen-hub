<?php

namespace App\Http\Livewire\Components\Company;

use App\Http\Livewire\Components\Traits\DeepnessFactor;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ChartExpandedModalComponent extends Component
{
    use ChartBuilderTrait;

    public $isOpen = false;
    public $chartType;
    public $chart;
    public $chartData = [];
    public $labels = [];

    protected $listeners = ['openChartExpandedModal' => 'toggleModal', 'chartClicked' => 'chartClicked'];

    public function chartClicked($xIndex) {
        $this->emit('showChartPointInfo', $xIndex, $this->chartData[$this->chartType]);
    }

    public function toggleModal($chartType = null)
    {
        $this->chartType = $chartType;
        $this->isOpen = !$this->isOpen;

        if ($this->isOpen && $this->chartType) {
            $this->chart = $this->chartData[$this->chartType];
        }
    }

    public function initializeCharts()
    {
        // Determine the period
        $period = CarbonPeriod::create(Carbon::now(), Carbon::now()->addDays(2));

        // Loop through each chart type and get the data associated to this type
        foreach (['green', 'blue', 'grey'] as $chartType) {
            $this->buildChart($period, $chartType, DeepnessFactor::HOURS);
        }
    }

    public function mount()
    {
        $this->initializeCharts();
    }

    public function render()
    {
        return view('livewire.components.company.chart-expanded-modal-component');
    }
}
