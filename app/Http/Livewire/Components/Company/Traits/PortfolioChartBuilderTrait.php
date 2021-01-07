<?php


namespace App\Http\Livewire\Components\Company\Traits;


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
     */
    public function buildLabels($period)
    {
        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            // Get date labels
            $this->labels[] = $date->format('M d');
        }
    }

    /**
     * Build the labels for a chart in a given carbon period
     *
     * @param $period
     */
    public function buildExtensiveLabels($period)
    {
        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            // Loop through each hour in the period
            for ($i = 0; $i < 24; $i++) {
                // Get date labels
                $this->labels[] = $date->format('M d') . ' - ' . $i . ':00';
            }
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
            'hydrogenType' => $chartType,
            'min' => null,
            'max' => null,
            'totalLoads' => [],
            'demand' => [],
            'shortage' => null
        ];

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->tradesAfterCarbonDate($now)->where('hydrogen_type', '=', $chartType);

        // Get every demand between now and the next 7 days or longer
        $dayLogs = auth()->user()->company->dayLogsBetweenCarbonDates($now, $end);

        $possibleBoundaries = [];

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            // Get produce, demand and storage for the given date
            $section = $this->getDayLogSection($dayLogs, $date, $chartType);

            if ($section) {
                foreach ($section as $key => $sectionEntry) {
                    $this->chartData[$chartType][$key][] = $sectionEntry;
                    $possibleBoundaries[] = $sectionEntry;
                }
            }
            else {
                foreach (['produce', 'demand', 'store'] as $key) {
                    $this->chartData[$chartType][$key][] = 0;
                }
            }

            // Get total load for the given date
            $totalLoad = $this->getTotalLoad($trades, $date, $now);
            $totalLoad = $totalLoad + $this->chartData[$chartType]['produce'][$index]; // Add the produced hydrogen of today
            $totalLoad = $totalLoad - $this->chartData[$chartType]['store'][$index]; // Subtract the stored hydrogen of today

            $this->chartData[$chartType]['totalLoads'][] = $totalLoad;
            $possibleBoundaries[] = $totalLoad;

            // Get the shortage if it wasn't already present
            $shortage = $this->chartData[$chartType]['shortage'];
            $demand = $this->chartData[$chartType]['demand'][$index];

            if (!$shortage && $totalLoad < $demand) {
                $this->chartData[$chartType]['shortage'] = $date->format('M d') . ' - ' . ($demand - $totalLoad) . ' units short';
            }
        }

        // Update the minimum and maximum
        $boundaries = $this->modifyBoundaries(min($possibleBoundaries), max($possibleBoundaries));
        $this->chartData[$chartType]['min'] = $boundaries[0];
        $this->chartData[$chartType]['max'] = $boundaries[1];
    }

    /**
     * Build extensive chart data in a given carbon period
     *
     * @param $now
     * @param $period
     * @param $end
     * @param $chartType
     */
    public function buildExtensiveChart($now, $end, $period, $chartType, $deepnessFactor)
    {
        // Create a new set of data for this chart type so we can modify it
        $this->chartData[$chartType] = [
            'hydrogenType' => $chartType,
            'min' => null,
            'max' => null,
            'totalLoad' => [],
            'bought' => [],
            'sold' => [],
            'produce' => [],
            'demand' => [],
            'store' => [],
            'shortage' => null
        ];

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->tradesAfterCarbonDate($now)->where('hydrogen_type', '=', $chartType);

        // Get every demand between now and the next 7 days or longer
        $dayLogs = auth()->user()->company->dayLogsBetweenCarbonDates($now, $end);

        $possibleBoundaries = [];

        // Loop through each day in the period
        foreach ($period as $index=>$date) {
            $possibleBoundaries[] = 0;

            // Loop through each hour in the day
            for ($i = 0; $i < 24; $i++) {
                $totalLoad = 0;

                // Get the bought and sold values
                $boughtSoldValues = $this->getBoughtSold($trades, $date, $i);

                $this->chartData[$chartType]['bought'][] = $boughtSoldValues[0];
                $totalLoad += $boughtSoldValues[0]; // Add bought to total load

                $this->chartData[$chartType]['sold'][] = -$boughtSoldValues[1];
                $totalLoad -= $boughtSoldValues[1]; // Subtract sold from total load

                // Get produce, demand and store for the given date
                $section = $this->getDayLogSection($dayLogs, $date, $chartType);

                if ($section) {
                    foreach ($section as $key => $sectionEntry) {
                        if ($sectionEntry != null) {
                            $possibleBoundaries[] = $sectionEntry;

                            $this->chartData[$chartType][$key][] = $sectionEntry;

                            if ($key == 'produce' || $key == 'store') {
                                $possibleBoundaries[] = $sectionEntry;

                                if ($key == 'produce') {
                                    $totalLoad += $sectionEntry; // Add produce to total load
                                }
                                else {
                                    $totalLoad -= $sectionEntry; // Subtract store from total load
                                }
                            }
                        }
                        else {
                            $possibleBoundaries[] = 0;
                        }
                    }
                }
                else {
                    foreach (['produce', 'demand', 'store'] as $key) {
                        $this->chartData[$chartType][$key][] = 0;
                    }
                }

                // Get the shortage if it wasn't already present
                $shortage = $this->chartData[$chartType]['shortage'];
                $demand = $this->chartData[$chartType]['demand'][count($this->chartData[$chartType]['demand']) - 1];

                if (!$shortage && $totalLoad < $demand) {
                    $this->chartData[$chartType]['shortage'] = $date->format('M d') . ' - ' . $i . ':00' . ' ' . ($demand - $totalLoad) . ' units short';
                }

                // Set the total load
                $this->chartData[$chartType]['totalLoad'][] = $totalLoad;
                $possibleBoundaries[] = $totalLoad;
            }
        }

        // Make sure the array size is correct
        if ($deepnessFactor == DeepnessFactor::DAYS) {
            $finalChartData = [];
            $index = 0;
            foreach($this->chartData[$chartType] as $key => $entry) {
                if ($index++ % 24 == 0) {
                    $finalChartData[$key] = $entry;
                }
            }
            $this->chartData[$chartType] = $finalChartData;
        }

        // Update the minimum and maximum
        $boundaries = $this->modifyBoundaries(min($possibleBoundaries), max($possibleBoundaries));
        $this->chartData[$chartType]['min'] = $boundaries[0];
        $this->chartData[$chartType]['max'] = $boundaries[1];
    }

    private function getBoughtSold($trades, $date, $hour) {
        $totalBought = 0;
        $totalSold = 0;
        $date = new Carbon($date->format('y-m-d') . ' ' . $hour . ':00');

        foreach ($trades as $trade) {
            // Round end date/time
            $end = $trade->endRaw;
            $hour = (int)$date->format('h');

            if ((int)$end->format('i') >= 30) {
                $hour += 1;
            }

            $end = new Carbon($end->format('y-m-d') . ' ' . $hour . ':00');

            // Check if the trade is still running in this hour
            if ($date->lessThan($end)) {
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
     * Get the day log section for a given date with a day logs collection
     *
     * @param $dayLogs
     * @param $date
     * @param $hydrogenType
     * @return null | array
     */
    private function getDayLogSection($dayLogs, $date, $hydrogenType) {
        $section = null;

        // Get first because faker generates multiple day logs with the same date, normally this isn't possible
        $dayLog = $dayLogs->where('date', '=', $date->toDateString())->first();

        if ($dayLog && !$dayLog->sections->isEmpty() && !$dayLog->sections->where('hydrogen_type', '=', $hydrogenType)->isEmpty()) {
            // Get first because we don't have type splitting yet
            $section = $dayLog->sections->where('hydrogen_type', '=', $hydrogenType)->first();
        }

        return $section ? [
            'produce' => $section->produce,
            'demand' => $section->demand,
            'store' => $section->store
        ] : null;
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
