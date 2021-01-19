<?php


namespace App\Http\Livewire\Components\Dashboard\Traits;


use App\Models\Trade;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

trait DashboardGraphTrait
{
    /**
     * Wrapper for both min and max limit functions
     *
     * @param $typeOfGraph
     */
    private function setLimits($typeOfGraph)
    {
        $this->setLimitMax($typeOfGraph);
        $this->setLimitMin($typeOfGraph);
    }

    /**
     * Set the max limit for $typeOfGraph
     *
     * @param $typeOfGraph
     */
    private function setLimitMax($typeOfGraph)
    {
        //Get the highest value for type of graph in the specified period
        $max = $this->determineLimit($typeOfGraph, 1);
        //Add a small margin to make sure the outer bounds have enough space
        $limit = ($max + ($max * 0.05));
        $this->chartProperties[$typeOfGraph]['limits']['max'] = $limit;
    }

    /**
     * Set the min limit for $typeOfGraph
     *
     * @param $typeOfGraph
     */
    private function setLimitMin($typeOfGraph)
    {
        //Get the lowest value for type of graph in the specified period
        $min = $this->determineLimit($typeOfGraph, 0);
        //Add a small margin to make sure the outer bounds have enough space
        $limit = ($min - ($min * 0.05));
        $this->chartProperties[$typeOfGraph]['limits']['min'] = $limit;
    }

    /**
     * Determines the limits for different types of graphs
     *
     * @param $typeOfGraph
     * @param $minOrMax
     * @return int|mixed
     */
    private function determineLimit($typeOfGraph, $minOrMax)
    {
        switch ($typeOfGraph) {
            case "prices":
            {
                if ($minOrMax) {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->max('price_per_unit');
                } else {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->min('price_per_unit');
                }
            }
            case "mix":
            {
                if ($minOrMax) {
                    return 100;
                } else {
                    return 0;
                }
            }
            case "volumes":
            {
                if ($minOrMax) {
                    return 20000;
                } else {
                    return 0;
                }
            }
        }
    }

    /**
     * Set data for graph of type $typeGraph, using specified callback
     *
     * @param $typeOfGraph
     * @param $callback
     */
    private function getDataForGraph($typeOfGraph, $callback)
    {
        foreach ($this->period as $day) {
            foreach ($this->lineProperties[$typeOfGraph] as $hydrogen_type_line => $value) {
                if ($hydrogen_type_line !== "callback") {
                    $this->lineProperties[$typeOfGraph][$hydrogen_type_line]['data'][] = $this->apply_recursion_on_callback($callback,
                        $day, $hydrogen_type_line);
                }
            }
        }
    }

    /**
     * Used to apply recursion on multiple functions.
     * The recursion is used to step back a day when no average can be calculated
     *
     * @param $callback
     * @param $day
     * @param $hydrogen_type
     * @param  int  $depth
     * @param  int  $maxDepth
     * @return null
     */
    private function apply_recursion_on_callback($callback, $day, $hydrogen_type, $depth = 0, $maxDepth = 10)
    {
        if ($depth > $maxDepth) {
            return null;
        }

        $average = $callback($day, $hydrogen_type);

        if ($average < 1) {
            $average = $this->apply_recursion_on_callback($callback, $day->subDays(1), $hydrogen_type, $depth + 1);
        }

        return $average;
    }

    /**
     * Get average price for $day and $hydrogen_type in cents
     *
     * @param $day
     * @param $hydrogen_type
     * @param  int  $depth
     * @return int
     */
    private function getAveragePriceForDayAndH2TypeInCents($day, $hydrogen_type, $depth = 0)
    {
        return (int) ceil($this->getTradesMadeOnDayQuery($day)->where('hydrogen_type',
            '=', $hydrogen_type)->avg('price_per_unit'));
    }

    /**
     * Get the average amount of mix traded for $day
     *
     * @param $day
     * @return mixed
     */
    private function getAverageAmountOfMixTradedForDay($day)
    {
        return $this->getTradesMadeOnDayQuery($day)->avg('mix_co2');
    }

    /**
     * Get all the running trades on $day with type $hydrogen_type with added calculated column
     *
     * @param $day
     * @param $type_of_hydrogen
     * @return float|int
     */
    private function getAllRunningTradesWithCalculatedEndDate($day, $type_of_hydrogen)
    {
        $trades = Trade::fromQuery("
            SELECT *, DATE_ADD(deal_made_at, INTERVAL + duration HOUR) as end_date_time
            FROM trades
            WHERE hydrogen_type = ?
            AND deal_made_at IS NOT NULL
            HAVING end_date_time >= ? ",
            [$type_of_hydrogen, $day->toDateTimeString()]
        );

        $unitsTradedOnDay = 0;
        foreach ($trades as $trade) {
            $unitsTradedOnDay += $trade->getUnitsAtCarbonDate($day);
        }

        if (!count($trades)) {
            return 0;
        }

        return round($unitsTradedOnDay / count($trades), 0);
    }

    /**
     * Gets all trades where date made at $day
     *
     * @param  Carbon  $day
     * @return Trade|\Illuminate\Database\Eloquent\Builder
     */
    private function getTradesMadeOnDayQuery(Carbon $day)
    {
        return Trade::where('deal_made_at', "LIKE", $day->format('Y-m-d').'%');
    }
}
