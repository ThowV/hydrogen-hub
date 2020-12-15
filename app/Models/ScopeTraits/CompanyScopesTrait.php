<?php


namespace App\Models\ScopeTraits;


use App\Models\Trade;
use App\Models\User;
use Carbon\Carbon;

trait CompanyScopesTrait
{
    public function tradesAsResponder()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'responder_id');
    }

    public function tradesAsOwner()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id')->whereNotNull('responder_id');
    }

    public function listings()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id');
    }

    public function getTradesAttribute()
    {
        return $this->tradesAsResponder->merge($this->tradesAsOwner);
    }

    public function getBoughtTradesAttribute()
    {
        $boughtOffers = $this->tradesAsResponder->where('trade_type', 'offer');
        $soldRequests = $this->tradesAsOwner->where('trade_type', 'request');
        return $boughtOffers->merge($soldRequests);
    }

    public function getSoldTradesAttribute()
    {
        $soldOffers = $this->tradesAsResponder->where('trade_type', 'request');
        $BoughtRequests = $this->tradesAsOwner->where('trade_type', 'offer');
        return $soldOffers->merge($BoughtRequests);
    }

    public function getBoughtAttribute()
    {
        $boughtOffers = $this->tradesAsResponder->where('trade_type', 'offer')->sum('total_price');
        $soldRequests = $this->tradesAsOwner->where('trade_type', 'request')->sum('total_price');

        return $boughtOffers + $soldRequests;
    }

    public function getSoldAttribute()
    {
        $soldOffers = $this->tradesAsResponder->where('trade_type', 'request')->sum('total_price');
        $BoughtRequests = $this->tradesAsOwner->where('trade_type', 'offer')->sum('total_price');

        return $soldOffers + $BoughtRequests;
    }


    public function dayLogsBetweenCarbonDates(Carbon $start, Carbon $end)
    {
        return $this->dayLogs->where('date', '>=', $start)->where('date', '<=', $end);
    }

    public function tradesAfterCarbonDate(Carbon $start)
    {
        return $this->trades->where('end_raw', '>=', $start);
    }
}
