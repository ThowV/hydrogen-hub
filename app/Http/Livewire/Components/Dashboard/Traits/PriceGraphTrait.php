<?php


namespace App\Http\Livewire\Components\Dashboard\Traits;


use App\Models\Trade;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

trait PriceGraphTrait
{

    private function setLimitMax()
    {
        //Get the highest value for price per unit in the specified period
        $max = Trade::whereBetween('deal_made_at',
            [$this->period->getStartDate(), $this->period->getEndDate()])->max('price_per_unit');
        //Add a small margin to make sure the outer bounds have enough space
        $limit = ($max + ($max * 0.05));
        $this->chartProperties['limits']['max'] = $limit;
    }

    private function setLimitMin()
    {
        //Get the lowest value for price per unit in the specified period
        $min = Trade::whereBetween('deal_made_at',
            [$this->period->getStartDate(), $this->period->getEndDate()])->min('price_per_unit');
        //Add a small margin to make sure the outer bounds have enough space
        $limit = ($min - ($min * 0.05));
        $this->chartProperties['limits']['min'] = $limit;
    }

    private function getDataForGraph()
    {
        foreach ($this->period as $day) {
            foreach ($this->lineProperties as $key => $value) {
                $this->lineProperties[$key]['data'][] = $this->getAveragePriceForDayAndH2TypeInCents($day,
                    $key);
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
        $ceiledAverage = (int) ceil(Trade::where('deal_made_at', "LIKE", $day->format('Y-m-d').'%')->where('hydrogen_type',
            '=', $hydrogen_type)->avg('price_per_unit'));

        //If ceiled average is less than 1, we have no data to base an average on. In this case we want to use the previous day's average
        if ($ceiledAverage < 2) {
            $ceiledAverage = $this->getAveragePriceForDayAndH2TypeInCents($day->subDays(1), $hydrogen_type, $depth + 1);
        }

        return $ceiledAverage;
    }

    private function setPeriod()
    {
        $this->period = CarbonPeriod::create(Carbon::now()->subDays($this->limit - 1), Carbon::now());
    }

    private function setLabels()
    {
        foreach ($this->period as $day) {
            $this->priceGraphLabels[] = $day->format('M d');
        }
    }
}
