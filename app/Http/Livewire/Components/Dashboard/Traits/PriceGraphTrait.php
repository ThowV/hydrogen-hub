<?php


namespace App\Http\Livewire\Components\Dashboard\Traits;


use App\Models\Trade;

trait PriceGraphTrait
{
    private function setLimits($typeOfGraph){
        $this->setLimitMax($typeOfGraph);
        $this->setLimitMin($typeOfGraph);
    }

    private function setLimitMax($typeOfGraph)
    {
        //Get the highest value for price per unit in the specified period
        $max = $this->determineLimit($typeOfGraph, 'max');
        //Add a small margin to make sure the outer bounds have enough space
        $limit = ($max + ($max * 0.05));
        $this->chartProperties[$typeOfGraph]['limits']['max'] = $limit;
    }

    private function setLimitMin($typeOfGraph)
    {
        //Get the lowest value for price per unit in the specified period
        $min = $this->determineLimit($typeOfGraph, "min");
            //Add a small margin to make sure the outer bounds have enough space
        $limit = ($min - ($min * 0.05));
        $this->chartProperties[$typeOfGraph]['limits']['min'] = $limit;
    }

    private function determineLimit($typeOfGraph, $minOrMax)
    {
        switch ($typeOfGraph) {
            case "prices":
            {
                if ($minOrMax == "max") {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->max('price_per_unit');
                } else {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->min('price_per_unit');
                }
            }
            case "volumes":
            {
                if ($minOrMax == "max") {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->max('price_per_unit');
                } else {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->min('price_per_unit');
                }
            }
            case "mix":
            {
                if ($minOrMax == "max") {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->max('price_per_unit');
                } else {
                    return Trade::whereBetween('deal_made_at',
                        [$this->period->getStartDate(), $this->period->getEndDate()])->min('price_per_unit');
                }
            }
        }
    }

    private function getDataForGraph($typeOfGraph, $callback)
    {
        foreach ($this->period as $day) {
            foreach ($this->lineProperties[$typeOfGraph] as $key => $value) {
                if ($key !== "callback") {
                    $this->lineProperties[$typeOfGraph][$key]['data'][] = $callback($day, $key);
                }
            }
        }
    }

    private function getAveragePriceForDayAndH2TypeInCents($day, $hydrogen_type, $depth = 0)
    {
        //Used to prevent infinite recursion
        if ($depth > 9) {
            return null;
        }

        //Round the average up
        $ceiledAverage = (int) ceil(Trade::where('deal_made_at', "LIKE",
            $day->format('Y-m-d').'%')->where('hydrogen_type',
            '=', $hydrogen_type)->avg('price_per_unit'));

        //If ceiled average is less than 1, we have no data to base an average on. In this case we want to use the previous day's average
        if ($ceiledAverage < 2) {
            $ceiledAverage = $this->getAveragePriceForDayAndH2TypeInCents($day->subDays(1), $hydrogen_type, $depth + 1);
        }

        return $ceiledAverage;
    }
}
