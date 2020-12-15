<?php

namespace App\Http\Livewire\Components\Company;

use App\Events\PermissionDenied;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ChartOverviewComponent extends Component
{
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
        $periodEnd = $now->copy()->addDays(6);
        $period = CarbonPeriod::create($now->copy(), $periodEnd->copy());

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            # Get date labels
            $this->labels[] = $date->format('M d');
        }

        // Loop through each chart type and get the data associated to this type
        foreach ($this->chartTypes as $chartType) {
            $this->buildChart($now, $period, $periodEnd, $chartType);
        }
    }

    public function buildChart($now, $period, $periodEnd, $chartType)
    {
        // Create a new set of data for this chart type so we can modify it
        $this->chartData[$chartType] = [
            'hydrogen_type' => $chartType,
            'min' => 0,
            'max' => 100,
            'totalLoads' => [],
            'demands' => [],
            'shortage' => null
        ];

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->tradesAfterCarbonDate($now)->where('hydrogen_type', '=', $chartType);

        // Get every demand between now and the next 7 days or longer
        $dayLogs = auth()->user()->company->dayLogsBetweenCarbonDates($now, $periodEnd);

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            # Get total load for the given date
            $totalLoad = 0;

            foreach ($trades as $trade) {
                // Check if the trade is still running on this date
                //dd($date, $trade->endRaw, $date->lessThanOrEqualTo($trade->endRaw));
                if ($date->lessThanOrEqualTo($trade->endRaw)) {
                    if ($trade->demander->id == auth()->user()->id) {
                        // We are receiving hydrogen
                        $totalLoad += $trade->getUnitsAtCarbonDate($now);
                    } else {
                        // We are sending hydrogen
                        $totalLoad -= $trade->getUnitsAtCarbonDate($now);
                    }
                }
            }

            $this->chartData[$chartType]['totalLoads'][] = $totalLoad;
            $boundaries[] = $totalLoad;

            # Get demand for the given date
            # Get first because faker generates multiple day logs with the same date, normally this isn't possible
            $dayLog = $dayLogs->where('date', '=', $date->toDateString())->first();

            if ($dayLog && !$dayLog->sections->isEmpty() && !$dayLog->sections->where('hydrogen_type', '=', $chartType)->isEmpty()) {
                # Get first because we don't have type splitting yet
                $section = $dayLog->sections->where('hydrogen_type', '=', $chartType)->first();
                $this->chartData[$chartType]['demands'][] = $section->demand;
                $boundaries[] = $section->demand;
            }
            else {
                $this->chartData[$chartType]['demands'][] = 0;
            }

            # Update the minimum and maximum
            foreach ($boundaries as $boundary) {
                if ($boundary > $this->chartData[$chartType]['max']) {
                    $this->chartData[$chartType]['max'] = (int)($boundary + ceil(0.15 * $boundary));
                }
                if ($boundary < $this->chartData[$chartType]['min']) {
                    $this->chartData[$chartType]['min'] = (int)($boundary + ceil(0.15 * $boundary));
                }
            }

            # Get the shortage if it wasn't already present
            $shortage = $this->chartData[$chartType]['shortage'];
            $demand = $this->chartData[$chartType]['demands'][$index];

            if (!$shortage && $totalLoad < $demand) {
                $this->chartData[$chartType]['shortage'] = $date->format('M d') . ' - ' . ($demand - $totalLoad) . ' units short';
            }
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
