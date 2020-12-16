<?php


namespace App\Http\Livewire\Components\Company;


trait ChartBuilderTrait
{
    /**
     * Build the labels for a chart in a given carbon period
     *
     * @param $period
     */
    public function buildLabels($period)
    {
        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            # Get date labels
            $this->labels[] = $date->format('M d');
        }
    }

    /**
     * Build chart data in a given carbon period
     *
     * @param $now
     * @param $period
     * @param $end
     * @param $chartType
     */
    public function buildChart($now, $end, $period, $chartType)
    {
        // Create a new set of data for this chart type so we can modify it
        $this->chartData[$chartType] = [
            'hydrogen_type' => $chartType,
            'min' => null,
            'max' => null,
            'totalLoads' => [],
            'demands' => [],
            'shortage' => null
        ];

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->tradesAfterCarbonDate($now)->where('hydrogen_type', '=', $chartType);

        // Get every demand between now and the next 7 days or longer
        $dayLogs = auth()->user()->company->dayLogsBetweenCarbonDates($now, $end);

        $possibleBoundaries = [];

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            # Get total load for the given date
            $totalLoad = $this->getTotalLoad($trades, $date, $now);

            $this->chartData[$chartType]['totalLoads'][] = $totalLoad;
            $possibleBoundaries[] = $totalLoad;

            # Get demand for the given date
            $demand = $this->getDemand($dayLogs, $date, $chartType);

            $this->chartData[$chartType]['demands'][] = $demand;
            $possibleBoundaries[] = $demand;

            # Get the shortage if it wasn't already present
            $shortage = $this->chartData[$chartType]['shortage'];
            $demand = $this->chartData[$chartType]['demands'][$index];

            if (!$shortage && $totalLoad < $demand) {
                $this->chartData[$chartType]['shortage'] = $date->format('M d') . ' - ' . ($demand - $totalLoad) . ' units short';
            }
        }

        # Update the minimum and maximum
        $boundaries = $this->modifyBoundaries(min($possibleBoundaries), max($possibleBoundaries));
        $this->chartData[$chartType]['min'] = $boundaries[0];
        $this->chartData[$chartType]['max'] = $boundaries[1];
    }

    /**
     * Get the total load for a given date with a trade collection
     *
     * @param $trades
     * @param $date
     * @param $now
     * @return int
     */
    private function getTotalLoad($trades, $date, $now) {
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

        return $totalLoad;
    }

    /**
     * Get the demand for a given date with a day logs collection
     *
     * @param $dayLogs
     * @param $date
     * @param $hydrogenType
     * @return int
     */
    private function getDemand($dayLogs, $date, $hydrogenType) {
        $demand = 0;

        # Get first because faker generates multiple day logs with the same date, normally this isn't possible
        $dayLog = $dayLogs->where('date', '=', $date->toDateString())->first();

        if ($dayLog && !$dayLog->sections->isEmpty() && !$dayLog->sections->where('hydrogen_type', '=', $hydrogenType)->isEmpty()) {
            # Get first because we don't have type splitting yet
            $section = $dayLog->sections->where('hydrogen_type', '=', $hydrogenType)->first();
            $demand = $section->demand;
        }

        return $demand;
    }

    /**
     * Modify the boundaries for a chart
     *
     * @param $min
     * @param $max
     * @return int[]
     */
    private function modifyBoundaries($min, $max) {
        return [
            (int)($min + ceil(0.15 * $min)),
            (int)($max + ceil(0.15 * $max))
        ];
    }
}
