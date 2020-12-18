<?php


namespace App\Models\ScopeTraits;


use Carbon\Carbon;

trait TradeAttributesTrait
{
    /**
     * Get the total volume of hydrogen of this trade
     *
     * @return float|int
     */
    public function getTotalVolumeAttribute()
    {
        return $this->duration * $this->units_per_hour;
    }

    /**
     * Get the end date of this trade in string format
     *
     * @return string
     */
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

    /**
     * Get the end date of this trade in Carbon format
     *
     * @return Carbon
     */
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

    /**
     * Set time since deal attribute on the model instance
     *
     * @return mixed
     */
    public function getTimeSinceDealAttribute()
    {
        return $this->datesDiffToReadable(Carbon::now(), Carbon::parse($this->deal_made_at));
    }

    /**
     * Set trade's total price attribute on the model instance
     *
     * @return float|int
     */
    public function getTotalPriceAttribute()
    {
        return $this->duration * $this->units_per_hour * $this->price_per_unit;
    }

    /**
     * Set the trade's expires at attribute in readable format
     *
     * @return string
     */
    public function getExpiresAtReadableAttribute()
    {
        return Carbon::parse($this->expires_at)->toDateString();
    }

    /**
     * Get the trade's units at carbon date
     *
     * @param $date
     * @return float|int
     */
    public function getUnitsAtCarbonDate($date)
    {
        $dealMadeAt = Carbon::parse($this->deal_made_at);
        $end = $dealMadeAt->copy()->addHours($this->duration);
        $durationToday = 24;

        if ($date->diffInDays($end) == 0) {
            // Only a part of today the company will be provided with the units
            $durationToday = ceil($date->diffInMinutes($end) / 60);
        }

        return $this->units_per_hour * $durationToday;
    }
}
