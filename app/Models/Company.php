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
     * Gets the activities for a company, either as an activity string, or an array
     *
     * @param  bool  $asArray
     * @return array
     */
    public function getActivities($asArray = true)
    {
        $activities = [];
        foreach ($this->boughtTrades as $trade) {
            if ($trade instanceof Trade) {
                if($asArray){
                    $activities[] = ["bought",$trade->units_per_hour,$trade->end,$trade->hydrogen_type,($trade->price_per_unit / 100)];
                }else{
                    $activities[] = "bought ".$trade->units_per_hour."/h for ".$trade->end." of ".$trade->hydrogen_type." hydrogen at the price of €".($trade->price_per_unit / 100).'/unit';
                }
            }
        }
        foreach ($this->soldTrades as $trade) {
            if ($trade instanceof Trade) {
                if($asArray){
                    $activities[] = ["sold",$trade->units_per_hour,$trade->end,$trade->hydrogen_type,($trade->price_per_unit / 100)];
                }else{
                    $activities[] = "sold ".$trade->units_per_hour."/h for ".$trade->end." of ".$trade->hydrogen_type." hydrogen at the price of €".($trade->price_per_unit / 100).'/unit';
                }
            }
        }

        return $activities;
    }
}
