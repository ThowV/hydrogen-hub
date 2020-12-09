<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property int $owner_id
 * @property string|null $logo_path
 * @property int $usable_fund
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyDayLog[] $dayLogs
 * @property-read int|null $day_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $employees
 * @property-read int|null $employees_count
 * @property-read mixed $bought
 * @property-read mixed $bought_trades
 * @property-read mixed $sold
 * @property-read mixed $sold_trades
 * @property-read mixed $trades
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trade[] $listings
 * @property-read int|null $listings_count
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trade[] $tradesAsOwner
 * @property-read int|null $trades_as_owner_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trade[] $tradesAsResponder
 * @property-read int|null $trades_as_responder_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUsableFund($value)
 * @mixin \Eloquent
 */
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
        return $this->hasManyThrough(Trade::class, User::class, '', 'owner_id')->whereNull('responder_id');
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
