<?php

namespace App\Http\Livewire\Components\Company;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ChartOverview extends Component
{
    private $chart_types = ['blue', 'green', 'grey'];
    private $chart_data = [];
    private $dayLabels = [];

    private function buildChart()
    {
        // Get the period
        $now = Carbon::now();
        $periodEnd = $now->copy()->addDays(6);
        $period = CarbonPeriod::create($now->copy(), $periodEnd->copy());

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            # Get date labels
            $this->dayLabels[] = $date->format('M d');
        }

        // Loop through each chart type and get the data associated to this type
        foreach ($this->chart_types as $chart_type) {
            // Create a new set of data for this chart type so we can modify it
            $this->chart_data[$chart_type] = [
                'hydrogen_type' => $chart_type,
                'min' => 0,
                'max' => 100,
                'totalLoads' => [],
                'demands' => [],
                'shortage' => null
            ];

            // Get every trade that is active between now and the next 7 days or longer
            $trades = auth()->user()->company->trades->where('end_raw', '>=', $now->copy())
                ->where('hydrogen_type', '=', $chart_type);

            // Get every demand between now and the next 7 days or longer
            $dayLogs = auth()->user()->company->dayLogs->where('date', '>=', $now->copy())->where('date', '<=', $periodEnd->copy());

            // Loop through each day in the period
            foreach ($period as $index=>$date) {
                # Get total load for the given date
                $totalLoad = 0;

                foreach ($trades as $trade) {
                    // Check if the trade is still running on this date
                    if ($date->lessThanOrEqualTo($trade->endRaw)) {
                        if ($trade->demander->id == auth()->user()->id) {
                            // We are receiving hydrogen
                            $totalLoad += $trade->unitsToday;
                        } else {
                            // We are sending hydrogen
                            $totalLoad -= $trade->unitsToday;
                        }
                    }
                }

                $this->chart_data[$chart_type]['totalLoads'][] = $totalLoad;
                $boundaries[] = $totalLoad;

                # Get demand for the given date
                # Get first because faker generates multiple day logs with the same date, normally this isn't possible
                $dayLog = $dayLogs->where('date', '=', $date->toDateString())->first();

                if ($dayLog && !$dayLog->sections->isEmpty() && !$dayLog->sections->where('hydrogen_type', '=', $chart_type)->isEmpty()) {
                    # Get first because we don't have type splitting yet
                    $section = $dayLog->sections->where('hydrogen_type', '=', $chart_type)->first();
                    $this->chart_data[$chart_type]['demands'][] = $section->demand;
                    $boundaries[] = $section->demand;
                }
                else {
                    $this->chart_data[$chart_type]['demands'][] = 0;
                }

                # Update the minimum and maximum
                foreach ($boundaries as $boundary) {
                    if ($boundary > $this->chart_data[$chart_type]['max']) {
                        $this->chart_data[$chart_type]['max'] = $boundary + ceil(0.15 * $boundary);
                    }
                    if ($boundary < $this->chart_data[$chart_type]['min']) {
                        $this->chart_data[$chart_type]['min'] = $boundary + ceil(0.15 * $boundary);
                    }
                }

                # Get the shortage if it wasn't already present
                $shortage = $this->chart_data[$chart_type]['shortage'];
                $demand = $this->chart_data[$chart_type]['demands'][$index];

                if (!$shortage && $totalLoad < $demand) {
                    $this->chart_data[$chart_type]['shortage'] = $date->format('M d') . ' - ' . ($demand - $totalLoad) . ' units short';
                }
            }
        }
    }

    public function render()
    {
        $this->buildChart();

        return view('livewire.components.company.chart-overview')
            ->withLabels($this->dayLabels)->withChartData($this->chart_data);
    }
}
