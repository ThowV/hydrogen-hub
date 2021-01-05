<?php

namespace App\Http\Livewire\Components\Company;

use App\Http\Livewire\Components\Company\Traits\DeepnessFactor;
use App\Http\Livewire\Components\Company\Traits\PortfolioChartBuilderTrait;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ChartExpandedModalComponent extends Component
{
    use PortfolioChartBuilderTrait;

    public $isOpen = false;
    public $chartType;
    public $chart;
    public $chartData = [];
    public $labels = [];

    protected $listeners = ['openChartExpandedModal' => 'toggleModal'];

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
        // Get the period
        $now = Carbon::now();
        $end = $now->copy()->addDays(1);
        $period = CarbonPeriod::create($now->copy(), $end->copy());

        $this->buildExtensiveLabels($period);

        // Loop through each chart type and get the data associated to this type
        foreach (['green', 'blue', 'grey'] as $chartType) {
            $this->buildExtensiveChart($now, $end, $period, $chartType, DeepnessFactor::HOURS);
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
