<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
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
}
