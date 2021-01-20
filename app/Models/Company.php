<?php

namespace App\Models;

use App\Models\ScopeTraits\CompanyActivityTrait;
use App\Models\ScopeTraits\CompanyScopesTrait;
use App\Models\ScopeTraits\CompanyShortTrait;
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
 * @method static \IlluOminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
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
    use CompanyScopesTrait;
    use CompanyActivityTrait;
    use CompanyShortTrait;

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

    public function hydrogenInterests()
    {
        return $this->hasMany(CompanyHydrogenInterest::class);
    }
}
