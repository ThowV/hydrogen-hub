<?php


namespace App\Models\ScopeTraits;


use Carbon\Carbon;

class TradeAttributesTrait
{
    public function getTotalVolumeAttribute()
    {
        return $this->duration * $this->units_per_hour;
    }

    public function getEndAttribute()
    {
        if ($this->deal_made_at) {
            // If the trade has been closed we should count down
            return $this->datesDiffToReadable(Carbon::now(),
                Carbon::parse($this->deal_made_at)->addHours($this->duration));
        } else {
            // If the trade has not been closed yet the duration should stay the same
            return $this->datesDiffToReadable(Carbon::now(), Carbon::now()->addHours($this->duration));
        }
    }

    public function getEndRawAttribute()
    {
        if ($this->deal_made_at) {
            // If the trade has been closed we should count down
            return Carbon::parse($this->deal_made_at)->addHours($this->duration);
        } else {
            // If the trade has not been closed yet the duration should stay the same
            return Carbon::now()->addHours($this->duration);
        }
    }

    public function getTimeSinceDealAttribute()
    {
        return $this->datesDiffToReadable(Carbon::now(), Carbon::parse($this->deal_made_at));
    }

    public function getTotalPriceAttribute()
    {
        return $this->duration * $this->units_per_hour * $this->price_per_unit;
    }

    public function getExpiresAtReadableAttribute()
    {
        return Carbon::parse($this->expires_at)->toDateString();
    }


}
