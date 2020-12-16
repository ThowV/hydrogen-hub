<?php

namespace App\Http\Livewire\Components\Company;

use App\Events\PermissionDenied;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ChartOverviewComponent extends Component
{
    use ChartBuilderTrait;

    public $chartTypes = ['blue', 'green', 'grey'];
    public $chartData = [];
    public $labels = [];

    protected $listeners = ['chartTypesUpdated' => 'chartTypesUpdated'];

    public function chartTypesUpdated()
    {
        // ChartJS bugs out if you do not refresh the page
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

    public function buildCharts()
    {
        // Get the chart types
        $this->chartTypes = auth()->user()->company->hydrogenInterestsAsArray;

        // Get the period
        $now = Carbon::now();
        $end = $now->copy()->addDays(6);
        $period = CarbonPeriod::create($now->copy(), $end->copy());

        $this->buildLabels($period);

        // Loop through each chart type and get the data associated to this type
        foreach ($this->chartTypes as $chartType) {
            $this->buildChart($now, $end, $period, $chartType);
        }
    }

    public function mount()
    {
        $this->buildCharts();
    }

    public function render()
    {
        return view('livewire.components.company.chart-overview-component');
    }
}
