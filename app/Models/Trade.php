<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Trade
 *
 * @property int $id
 * @property int $owner_id
 * @property int|null $responder_id
 * @property string|null $deal_made_at
 * @property string $trade_type
 * @property string $hydrogen_type
 * @property int $units_per_hour
 * @property int $duration
 * @property int $price_per_unit
 * @property int $mix_co2
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $end
 * @property-read mixed $total_price
 * @property-read mixed $total_volume
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\User|null $responder
 * @method static \Illuminate\Database\Eloquent\Builder|Trade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trade query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereDealMadeAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereHydrogenType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereMixCo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade wherePricePerUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereResponderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereTradeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereUnitsPerHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trade whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'responder_id',
        'deal_made_at',
        'trade_type',
        'hydrogen_type',
        'units_per_hour',
        'duration',
        'price_per_unit',
        'mix_co2',
        'expires_at',
    ];

    public function getTotalVolumeAttribute()
    {
        return $this->duration * $this->units_per_hour;
    }

    public function getEndAttribute()
    {
        $now = Carbon::now();
        $end = $now->copy()->addHours($this->duration);

        $daysDiff = $now->diffInDays($end);
        $weeksDiff = $now->diffInWeeks($end);
        $monthsDiff = $now->diffInMonths($end);

        if ($monthsDiff >= 1) {
            $diffMsg = $monthsDiff . ' month' . ($monthsDiff > 1 ? 's' : '');

            $endWithDays = $now->copy()->addDays($daysDiff);
            $endWithMonths = $now->copy()->addMonths($monthsDiff);
            $extraDays = $endWithMonths->diffInDays($endWithDays);

            if ($extraDays > 0) {
                $diffMsg .= ' and ' . $extraDays . ' day' . ($extraDays > 1 ? 's' : '');
            }

            return $diffMsg;
        } elseif ($weeksDiff >= 1) {
            $diffMsg = $weeksDiff . ' week' . ($weeksDiff > 1 ? 's' : '');

            $endWithDays = $now->copy()->addDays($daysDiff);
            $endWithWeeks = $now->copy()->addWeeks($weeksDiff);
            $extraDays = $endWithWeeks->diffInDays($endWithDays);

            if ($extraDays > 0) {
                $diffMsg .= ' and ' . $extraDays . ' day' . ($extraDays > 1 ? 's' : '');
            }

            return $diffMsg;
        } elseif ($daysDiff >= 1) {
            return $daysDiff . ' day' . ($daysDiff > 1 ? 's' : '');
        }
    }

    public function getTotalPriceAttribute()
    {
        return $this->duration * $this->units_per_hour * $this->price_per_unit;
    }

    public function getExpiresAtReadableAttribute()
    {
        return Carbon::parse($this->expires_at)->toDateString();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
