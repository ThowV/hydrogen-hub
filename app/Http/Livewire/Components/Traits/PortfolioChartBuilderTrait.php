<?php


namespace App\Http\Livewire\Components\Traits;


use Carbon\Carbon;

abstract class DeepnessFactor
{
    const DAYS = 0;
    const HOURS = 1;
}

trait PortfolioChartBuilderTrait
{

    /**
     * Build the labels for a chart in a given carbon period
     *
     * @param $period
     * @param $deepnessFactor
     * @return array
     */
    public function buildLabels($period, $deepnessFactor)
    {
        $labels = [];

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            if ($deepnessFactor == DeepnessFactor::DAYS) {
                $labels[] = $date->format('M d');
            }
            else {
                // Figure out the start and end hour
                $startHour = 0;
                $endHour = 24;

                if ($index == 0) {
                    $startHour = (int)$period->startDate->format('h');
                }

                if ($index == count($period) - 1) {
                    $endHour = (int)$period->endDate->format('h');
                }

                // Loop through each hour in the period
                for ($i = $startHour; $i < $endHour; $i++) {
                    // Get date labels
                    $labels[] = $date->format('M d') . ' - ' . $i . ':00';
                }
            }
        }

        return $labels;
    }

    /**
     * Build extensive chart data in a given carbon period
     *
     * @param $period
     * @param $chartType
     * @param $deepnessFactor
     */
    public function buildChart($period, $chartType, $deepnessFactor=DeepnessFactor::DAYS)
    {
        // Create a new set of data for this chart type so we can modify it
        $this->chartData[$chartType] = [
            'hydrogenType' => $chartType,
            'period' => $period,
            'labels' => $this->buildLabels($period, $deepnessFactor),
            'min' => null,
            'max' => null,
            'totalLoad' => [],
            'bought' => [],
            'sold' => [],
            'produce' => [],
            'demand' => [],
            'store' => [],
            'shortage' => null,
            'possibleMinMax' => [],
            'trades' => [],
            'dayLogs' => []
        ];

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->tradesAfterCarbonDate($period->startDate)->where('hydrogen_type', '=', $chartType);
        $this->chartData[$chartType]['trades'] = $trades;

        // Get every demand between now and the end date
        $dayLogs = auth()->user()->company->dayLogsBetweenCarbonDates($period->startDate, $period->endDate);
        $this->chartData[$chartType]['dayLogs'] = $dayLogs ;

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            // Figure out the start and end hour
            $startHour = 0;
            $endHour = 24;

            if ($deepnessFactor == DeepnessFactor::HOURS) {
                if ($index == 0) {
                    $startHour = (int)$period->startDate->format('h');
                }

                if ($index == count($period) - 1) {
                    $endHour = (int)$period->endDate->format('h');
                }
            }

            // Loop through each hour in the day
            for ($i = $startHour; $i < $endHour; $i++) {
                $totalIn = 0;
                $totalOut = 0;

                $hydrogenIn = [];
                $hydrogenOut = [];

                // Get all values
                $boughtSoldValues = $this->getBoughtSold($trades, $date, $i); // Get the bought and sold values
                $hydrogenIn['bought'] = $boughtSoldValues[0]; // Add bought to hydrogen in
                $hydrogenOut['sold'] = $boughtSoldValues[1]; // Add sold to hydrogen out

                $section = $this->getDayLogSection($dayLogs, $date, $chartType); // Get produce, demand and store
                $hydrogenIn['produce'] = isset($section['produce']) ? (int)($section['produce'] / 24) : 0; // Add produce to hydrogen in
                $hydrogenOut['store'] = isset($section['store']) ? (int)($section['store'] / 24) : 0; // Add store to hydrogen out
                $demand = isset($section['demand']) ? (int)($section['demand'] / 24) : 0;


                foreach ($hydrogenIn as $key => $in) {
                    $this->chartData[$chartType][$key][] = $in;
                    $totalIn += $in;
                }

                foreach ($hydrogenOut as $key => $out) {
                    $this->chartData[$chartType][$key][] = -$out;
                    $totalOut += $out;
                }

                // Set the total load
                $totalLoad = $totalIn - $totalOut;
                $this->chartData[$chartType]['totalLoad'][] = $totalLoad;

                // Set the demand
                $this->chartData[$chartType]['demand'][] = $demand;

                // Push the possible boundaries
                $this->chartData[$chartType]['possibleMinMax'][] = $totalIn > $demand ? $totalIn : $demand;
                $this->chartData[$chartType]['possibleMinMax'][] = -$totalOut;
            }
        }

        // Make sure the array size is correct by checking if we have to reduce the array size to match days instead of hours
        if ($deepnessFactor == DeepnessFactor::DAYS) {
            $possibleMinMax = [];

            // Loop through each entry
            foreach($this->chartData[$chartType] as $key => $chartDataSet) {
                // Check if the data set is an array, we need to reduce its size from hours to days
                if (is_array($chartDataSet) && $key != 'labels' && $key != 'trades' && $key != 'dayLogs') {
                    $reducedChartDataSet = [];
                    $reducedChartDataSetIndex = 0;

                    // Loop through each value in the data set
                    foreach ($chartDataSet as $index => $chartDataSetEntry) {
                        if ($index % 24 == 0) {
                            $reducedChartDataSet[] = 0;

                            if ($index != 0) {
                                $possibleMinMax[] = $reducedChartDataSet[$reducedChartDataSetIndex];
                                $reducedChartDataSetIndex++;
                            }
                        }
                        // Last value does not match the modulo if so this value does not get inserted into possible min max
                        // Mitigate this by checking if it is the last value
                        else if ($index == count($chartDataSet) - 1) {
                            $possibleMinMax[] = $reducedChartDataSet[$reducedChartDataSetIndex];
                        }

                        $reducedChartDataSet[$reducedChartDataSetIndex] += $chartDataSetEntry;
                    }

                    $this->chartData[$chartType][$key] = $reducedChartDataSet;
                }
            }

            // Set the new possible min max
            $this->chartData[$chartType]['possibleMinMax'] = $possibleMinMax;

            //dd($this->chartData[$chartType]);
        }

        // Determine the shortage if it wasn't already present
        $shortage = $this->chartData[$chartType]['shortage'];

        if (!$shortage) {
            for ($i = 0; $i < count($this->chartData[$chartType]['demand']); $i++) {
                $totalLoad = $this->chartData[$chartType]['totalLoad'][$i];
                $demand = $this->chartData[$chartType]['demand'][$i];

                // Check if the total load is lower than the demand, if so, we have a shortage so we build the label
                $shortage = $demand - $totalLoad;
                if ($shortage > 0) {
                    $label = '';

                    if ($deepnessFactor == DeepnessFactor::DAYS) {
                        $date = $period->startDate->addDays($i);
                        $label = $date->format('M d');
                    }
                    if ($deepnessFactor == DeepnessFactor::HOURS) {
                        $date = $period->startDate->addHours($i);
                        $label = $date->format('M d') . ', ' . (($i + 2) % 24) . ':00';
                    }

                    $this->chartData[$chartType]['shortage'] = $label . ' - ' . $shortage . ' units short';
                    break;
                }
            }
        }

        // Determine the minimum and maximum
        $boundaries = $this->modifyBoundaries(
            min($this->chartData[$chartType]['possibleMinMax']),
            max($this->chartData[$chartType]['possibleMinMax'])
        );

        $this->chartData[$chartType]['min'] = $boundaries[0];
        $this->chartData[$chartType]['max'] = $boundaries[1];
    }

    /**
     * Build impact chart data in a given carbon period
     *
     * @param $period
     * @param $chartType
     * @param $deepnessFactor
     */
    public function buildImpactChart($period, $chartType)
    {
        $this->buildChart($period, $chartType, DeepnessFactor::DAYS);
    }

    /**
     * Get the total bought and sold values for a given hour
     *
     * @param $trades
     * @param $date
     * @param $hour
     * @return int[]
     */
    private function getBoughtSold($trades, $date, $hour) {
        $totalBought = 0;
        $totalSold = 0;

        try {
            $date = new Carbon($date->format('y-m-d') . ' ' . $hour . ':00');
        } catch (\Exception $e) {
            return [0, 0];
        }

        foreach ($trades as $trade) {
            // Round end date/time
            $end = $trade->endRaw;
            $end->minute = 0; // Round the hour down

            // Check if the trade is active in this hour
            if ($date->greaterThan(Carbon::create($trade->deal_made_at)) && $date->lessThan($end)) {
                if ($trade->demander->id == auth()->user()->id) {
                    // We are receiving hydrogen
                    $totalBought += $trade->units_per_hour;
                } else {
                    // We are sending hydrogen
                    $totalSold += $trade->units_per_hour;
                }
            }
        }

        return [$totalBought, $totalSold];
    }

    /**
     * Get the day log section for a given date with a day logs collection
     *
     * @param $dayLogs
     * @param $date
     * @param $hydrogenType
     * @return null | array
     */
    private function getDayLogSection($dayLogs, $date, $hydrogenType) {
        $section = [];

        // Get first because faker generates multiple day logs with the same date, normally this isn't possible
        $dayLog = $dayLogs->where('date', '=', $date->toDateString())->first();

        if ($dayLog && !$dayLog->sections->isEmpty() && !$dayLog->sections->where('hydrogen_type', '=', $hydrogenType)->isEmpty()) {
            // Get first because we don't have type splitting yet
            $section = $dayLog->sections->where('hydrogen_type', '=', $hydrogenType)->first();
        }

        return $section;
    }

    /**
     * Modify the boundaries for a chart
     *
     * @param $min
     * @param $max
     * @return int[]
     */
    public function modifyBoundaries($min, $max) {
        return [
            (int)($min + ceil(0.15 * $min)),
            (int)($max + ceil(0.15 * $max))
        ];
    }
}
