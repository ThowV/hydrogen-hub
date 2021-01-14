<?php


namespace App\Models\ScopeTraits;

use App\Models\Trade;
use Carbon\Carbon;

trait CompanyShortTrait
{

    /**
     *
     * @param  Carbon  $date
     * @return bool
     */
    public function isShortOnDayForType(Carbon $date, $type): bool
    {
        //Determine demand for the day with h2type
        $demandForDay = $this->getDemandForH2TypeAndCarbonDate($date,$type);

        //If we have no demand, we have no shortage
        if(!$demandForDay){
            return false;
        }

        //Calculate actual amount for the day
        //return is_negative(actual_amount - demand)
        return true;
    }

    /**
     * @param  Carbon  $date
     * @param $type
     * @return int
     */
    public function getDemandForH2TypeAndCarbonDate(Carbon $date, $type): int
    {
        foreach ($this->dayLogs()->where('date', $date->format('Y-m-d'))->first()->sections->where('hydrogen_type', $type) as $dayLogSection) {
            return $dayLogSection->demand;
        }
        return 0;
    }

    /**
     * Get amount of short on day
     *
     * @param  Carbon  $date
     * @return int
     */
    public function shortOnDayForType(Carbon $date): int
    {

    }

    /**
     * Gets company's trades where date made at $day
     *
     * @param  Carbon  $day
     * @return Trade[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    private function getTradesMadeOnDayForCompany(Carbon $day)
    {
        return Trade::where('deal_made_at', "LIKE", $day->format('Y-m-d').'%')->where('owner_id',
            $this->id)->orWhere('responder_id', $this->id)->get();
    }
}
