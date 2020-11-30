<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'logo_path',
        'usable_fund'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class);
    }

    public function dayLogs()
    {
        return $this->hasMany(CompanyDayLog::class);
    }

    public function tradesAsResponder()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'responder_id');
    }

    public function tradesAsOwner()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id')->whereNotNull('responder_id');
    }

    public function getTradesAttribute()
    {
        return $this->tradesAsResponder->merge($this->tradesAsOwner);
    }

    public function listings()
    {
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id');
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

    /**
     * Gets the activities for a company as an array
     *
     * @return array
     */
    public function getAllActivities()
    {
        $activities = collect();
        $this->getAllSpecificActivities($activities, 'bought');
        $this->getAllSpecificActivities($activities, 'sold');

        return array_values($activities->sortByDesc(5)->toArray());
    }

    /**
     * Get the activities based on the specific action performed
     *
     * @param $array
     * @param $action
     * @return void
     */
    public function getAllSpecificActivities(&$array, $action)
    {
        $property = $action."Trades";
        foreach ($this->$property as $trade) {
            if (!$trade instanceof Trade) continue;
            $array[] = [
                $action,
                $trade->units_per_hour,
                $trade->end,
                $trade->hydrogen_type,
                ($trade->price_per_unit / 100),
                $trade->deal_made_at
            ];
        }
    }
}
