<?php

namespace App\Http\Livewire\Components\Company;

use App\Events\PermissionDenied;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ChartOverviewComponent extends Component
{
    use ChartBuilderTrait;

    public $chartTypes = ['blue', 'green', 'grey'];
    public $chartData = [];
    public $labels = [];

    protected $listeners = ['chartTypesUpdated' => 'chartTypesUpdated', 'chartExpandedDataUpdated' => 'chartDataUpdated'];

    public function openChartExpandedModal($chartType)
    {
        $this->emit("openChartExpandedModal", $chartType);
    }

    public function chartTypesUpdated()
    {
        // ChartJS bugs out due to calculations if you do not refresh the page
        return redirect()->to('/company/portfolio');
    }

    public function openSelectionModal()
    {
        if (! auth()->user()->can('company.portfolio.write')) {
            \event(new PermissionDenied());

            return back();
        }

        $this->emit("openChartOverviewSelectionModal");
    }

    public function chartDataUpdated($chartDataUpdated) {
        $this->initializeCharts();

        $this->emit('chartDataOverviewsUpdated', $this->chartData);
    }

    public function initializeCharts()
    {
        // Get the chart types
        $this->chartTypes = auth()->user()->company->hydrogenInterestsAsArray;

        // Determine the period
        $period = CarbonPeriod::create(Carbon::now(), Carbon::now()->addDays(6));

        // Loop through each chart type and get the data associated to this type
        foreach ($this->chartTypes as $chartType) {
            $this->buildChart($period, $chartType);
        }
    }

    public function mount()
    {
        $this->initializeCharts();
    }

    public function render()
    {
        return view('livewire.components.company.chart-overview-component');
    }
}
