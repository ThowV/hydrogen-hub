<?php


namespace App\Http\Livewire\Components\Traits;


use Carbon\Carbon;

abstract class DeepnessFactor
{
    const DAYS = 0;
    const HOURS = 1;
}

abstract class BuildMethod
{
    const SET = 0;
    const RETURN = 1;
}

trait ChartBuilderTrait
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
                $labels[] = $date->format('M d, Y');
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
                    $labels[] = $date->format('M d, Y') . ' - ' . $i . ':00';
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
     * @param int $deepnessFactor
     */
    public function buildChart($period, $chartType, $deepnessFactor=DeepnessFactor::DAYS)
    {
        // Create a new set of data for this chart type so we can modify it
        $chartData[$chartType] = [
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
        $chartData[$chartType]['trades'] = $trades;

        // Get every demand between now and the end date
        $dayLogs = auth()->user()->company->dayLogsBetweenCarbonDates($period->startDate, $period->endDate);
        $chartData[$chartType]['dayLogs'] = $dayLogs ;

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
                $totalIn = '0';
                $totalOut = '0';

                $hydrogenIn = [];
                $hydrogenOut = [];

                // Get all values
                $boughtSoldValues = $this->getBoughtSold($trades, $date, $i); // Get the bought and sold values
                $hydrogenIn['bought'] = strval($boughtSoldValues[0]); // Add bought to hydrogen in
                $hydrogenOut['sold'] = strval($boughtSoldValues[1]); // Add sold to hydrogen out

                $section = $this->getDayLogSection($dayLogs, $date, $chartType); // Get produce, demand and store
                $hydrogenIn['produce'] = isset($section['produce']) ? strval((int)($section['produce'] / 24)) : "0"; // Add produce to hydrogen in
                $hydrogenOut['store'] = isset($section['store']) ? strval((int)($section['store'] / 24)) : "0"; // Add store to hydrogen out
                $demand = isset($section['demand']) ? strval((int)($section['demand'] / 24)) : "0";


                // Calculate total in
                foreach ($hydrogenIn as $key => $in) {
                    $this->chartData[$chartType][$key][] = strval($in);
                    $totalIn += $in;
                }

                // Calculate total out
                foreach ($hydrogenOut as $key => $out) {
                    $this->chartData[$chartType][$key][] = strval(-$out);
                    $totalOut += $out;
                }

                // Set the total load
                $totalLoad = $totalIn - $totalOut;
                $this->chartData[$chartType]['totalLoad'][] = strval($totalLoad);

                // Set the demand
                $this->chartData[$chartType]['demand'][] = strval($demand);

                // Push the possible boundaries
                $chartData[$chartType]['possibleMinMax'][] = $totalIn;
                $chartData[$chartType]['possibleMinMax'][] = $demand;
                $chartData[$chartType]['possibleMinMax'][] = -$totalOut;
            }
        }

        // Make sure the array size is correct by checking if we have to reduce the array size to match days instead of hours
        if ($deepnessFactor == DeepnessFactor::DAYS) {
            $possibleMinMax = [];

            // Loop through each entry
            foreach($chartData[$chartType] as $key => $chartDataSet) {
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

                    $chartData[$chartType][$key] = $reducedChartDataSet;
                }
            }

            // Set the new possible min max
            $chartData[$chartType]['possibleMinMax'] = $possibleMinMax;
        }

        // Determine the shortage if it wasn't already present
        $shortage = $chartData[$chartType]['shortage'];

        if (!$shortage) {
            for ($i = 0; $i < count($chartData[$chartType]['demand']); $i++) {
                $totalLoad = $chartData[$chartType]['totalLoad'][$i];
                $demand = $chartData[$chartType]['demand'][$i];

                $shortage = $this->getShortage($i, $period, $demand, $totalLoad, $deepnessFactor);

                if ($shortage != '') {
                    $chartData[$chartType]['shortage'] = $shortage;
                    break;
                }
            }
        }

        // Determine the minimum and maximum
        // Get the min and max
        $minMax = $this->getMinMax($chartData[$chartType]['possibleMinMax']);

        $chartData[$chartType]['min'] = $minMax[0];
        $chartData[$chartType]['max'] = $minMax[1];

        // Finalize
        $this->chartData[$chartType] = $chartData[$chartType];
    }

    /**
     * Build extensive combined chart data in a given carbon period
     *
     * @param $period
     * @param $chartType
     * @param $deepnessFactor
     * @return array
     */
    public function buildCombinedChart($period, $deepnessFactor=DeepnessFactor::DAYS)
    {
        $chartData = [
            'hydrogenType' => 'combined',
            'period' => $period,
            'labels' => $this->buildLabels($period, $deepnessFactor),
            'min' => 0,
            'max' => 0,
            'totalLoad' => [],
            'bought' => [],
            'sold' => [],
            'produce' => [],
            'demand' => [],
            'store' => [],
            'trades' => [],
            'possibleMinMax' => [0, 0],
            'shortage' => ''
        ];

        // Combine the charts
        $hydrogenInterests = auth()->user()->company->hydrogenInterests->toArray();
        foreach ($hydrogenInterests as $subChartType) {
            $subChartType = $subChartType['interest'];

            // Skip combined type
            if ($subChartType == 'combined') {
                continue;
            }

            // Check if the chart data is already built, if it isn't, build it.
            if (!array_key_exists($subChartType, $this->chartData)) {
                $this->buildChart($period, $subChartType, $deepnessFactor);
            }

            // Loop through the sub chart data and combine it.
            $subChartData = $this->chartData[$subChartType];

            foreach ($subChartData as $key=>$value) {
                if ($key == 'shortage' || $key == 'possibleMinMax' || $key == 'dayLogs') {
                    continue;
                }

                $combinedDataVal = $chartData[$key];

                // Update the min and max
                if (($key == 'min' && $value < $combinedDataVal) || ($key == 'max' && $value > $combinedDataVal)) {
                    $chartData[$key] = $value;
                }
                else if ($key == 'totalLoad' || $key == 'bought' || $key == 'sold' || $key == 'produce'
                    || $key == 'demand' || $key == 'store' || $key == 'trades') {

                    $possibleMinMax = [0, 0];

                    foreach ($value as $index=>$subDataEntry) {
                        // Add the array entry to the combined array
                        if (!is_numeric($subDataEntry) || count($combinedDataVal) < ($index+1)) {
                            $combinedDataEntry = $subDataEntry;
                            $chartData[$key][] = $combinedDataEntry;
                        }
                        else {
                            $combinedDataEntry = $chartData[$key][$index] + $subDataEntry;
                            $chartData[$key][$index] = $combinedDataEntry;
                        }

                        // Get the min and max
                        if (is_numeric($subDataEntry)) {
                            if ($combinedDataEntry < $possibleMinMax[0]) {
                                $possibleMinMax[0] = $combinedDataEntry;
                            }
                            if ($combinedDataEntry > $possibleMinMax[1]) {
                                $possibleMinMax[1] = $combinedDataEntry;
                            }
                        }
                    }

                    // Add possible min max to the combined possible min max values
                    if ($possibleMinMax[0] != 0) {
                        $chartData['possibleMinMax'][] = $possibleMinMax[0];
                    }
                    if ($possibleMinMax[1] != 0) {
                        $chartData['possibleMinMax'][] = $possibleMinMax[1];
                    }
                }
            }
        }

        // Get the shortage
        for ($i = 0; $i < count($chartData['demand']); $i++) {
            $totalLoad = $chartData['totalLoad'][$i];
            $demand = $chartData['demand'][$i];

            $shortage = $this->getShortage($i, $period, $demand, $totalLoad, $deepnessFactor);

            if ($shortage != '') {
                $chartData['shortage'] = $shortage;
                break;
            }
        }

        // Get the min and max
        $minMax = $this->getMinMax($chartData['possibleMinMax']);
        $chartData['min'] = $minMax[0];
        $chartData['max'] = $minMax[1];

        // Finalize
        $this->chartData['combined'] = $chartData;
        return $chartData;
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

    private function getMinMax($possibleMinMax) {
        // Determine the minimum and maximum
        $boundaries = $this->modifyBoundaries(
            min($possibleMinMax),
            max($possibleMinMax)
        );

        if ($boundaries[1] == 0) {
            $boundaries[1] = 100;
        }

        return $boundaries;
    }

    private function getShortage($add, $period, $demand, $totalLoad, $deepnessFactor) {
        // Check if the total load is lower than the demand, if so, we have a shortage so we build the label
        $shortage = $demand - $totalLoad;

        if ($shortage > 0) {
            $label = '';

            if ($deepnessFactor == DeepnessFactor::DAYS) {
                $date = $period->startDate->addDays($add);
                $label = $date->format('M d');
            }
            if ($deepnessFactor == DeepnessFactor::HOURS) {
                $date = $period->startDate->addHours($add);
                $label = $date->format('M d') . ', ' . (($add + 2) % 24) . ':00';
            }

            return $label . ' - ' . $shortage . ' units short';
        }

        return '';
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
            (int)($min + floor(0.15 * $min)),
            (int)($max + ceil(0.15 * $max))
        ];
    }
}
