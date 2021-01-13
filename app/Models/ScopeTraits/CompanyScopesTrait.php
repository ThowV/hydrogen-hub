<?php


namespace App\Models\ScopeTraits;


use App\Models\Trade;
use App\Models\User;
use Carbon\Carbon;

trait CompanyScopesTrait
{
    /**
     * Trades that have been completed, where you are the owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tradesAsResponder()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'responder_id');
    }

    /**
     * Trades that have been completed, where you are the responder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tradesAsOwner()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id')->whereNotNull('responder_id');
    }

    /**
     * Listings do not have a responder yet, which means you are always the owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function listings()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id');
    }

    /**
     * All trades that have been completed
     *
     * @return mixed
     */
    public function getTradesAttribute()
    {
        return $this->tradesAsResponder->merge($this->tradesAsOwner);
    }


    /**
     * All trades that have been completed where this company is receiving hydrogen
     *
     * @return mixed
     */
    public function getBoughtTradesAttribute()
    {
        $boughtOffers = $this->tradesAsResponder->where('trade_type', 'offer');
        $soldRequests = $this->tradesAsOwner->where('trade_type', 'request');
        return $boughtOffers->merge($soldRequests);
    }

    /**
     * All trades that have been completed where this company is sending hydrogen
     *
     * @return mixed
     */
    public function getSoldTradesAttribute()
    {
        $soldOffers = $this->tradesAsResponder->where('trade_type', 'request');
        $BoughtRequests = $this->tradesAsOwner->where('trade_type', 'offer');
        return $soldOffers->merge($BoughtRequests);
    }

    /**
     * The sum of the amount all the trades where this company received hydrogen
     *
     * @return mixed
     */
    public function getBoughtAttribute()
    {
        $boughtOffers = $this->tradesAsResponder->where('trade_type', 'offer')->sum('total_price');
        $soldRequests = $this->tradesAsOwner->where('trade_type', 'request')->sum('total_price');

        return $boughtOffers + $soldRequests;
    }

    /**
     * The sum of the amount of all the trades where this company sent hydrogen
     *
     * @return float|int
     */
    public function getSoldAttribute()
    {
        $soldOffers = $this->tradesAsResponder->where('trade_type', 'request')->sum('total_price');
        $BoughtRequests = $this->tradesAsOwner->where('trade_type', 'offer')->sum('total_price');

        return $soldOffers + $BoughtRequests;
    }

    /**
     * The hydrogen interests in array format
     *
     * @return array
     */
    public function getHydrogenInterestsAsArrayAttribute()
    {
        $interests = [];

        foreach ($this->hydrogenInterests as $hydrogenInterest) {
            $interests[] = $hydrogenInterest->interest;
        }

        return $interests;
    }

    /**
     * Get all the day logs for this company between two dates
     *
     * @param  Carbon  $start
     * @param  Carbon  $end
     * @return mixed
     */
    public function dayLogsBetweenCarbonDates(Carbon $start, Carbon $end)
    {
        return $this->dayLogs->where('date', '>=', $start)->where('date', '<=', $end);
    }


    /**
     * Get all the trades a company has been participating in after given date
     *
     * @param  Carbon  $start
     * @return mixed
     */
    public function tradesAfterCarbonDate(Carbon $start)
    {
        return $this->trades->where('end_raw', '>=', $start);
    }

    public function getTotalVolumesTradedAttribute()
    {
        $return = 0;
        foreach ($this->trades as $trade) {
            $return += $trade->total_volume;
        }
        return $return;
    }
}
