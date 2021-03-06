<?php

namespace App\Models;

use App\Models\ScopeTraits\TradeAttributesTrait;
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
    use TradeAttributesTrait;

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

    private function datesDiffToReadable(Carbon $dateStart, Carbon $dateEnd)
    {
        /*
         * Tells us whether or not the date was or has to be added to the output message.
         * Makes sure we get the following formats:
         *      years, months, days
         *      months, days
         *      days, hours
         *      hours, minutes
         *      minutes, seconds
         *      seconds
         *
         * idx => [carbon notation (cn), readable notation (rn), [next accepted message values]]
         */
        $diffMsgModifiers = [
            ['y', 'year', [true, true, true, false, false, false]],
            ['m', 'month', [false, true, true, false, false, false]],
            ['d', 'day', [false, false, true, true, false, false]],
            ['h', 'hour', [false, false, false, true, true, false]],
            ['i', 'minute', [false, false, false, false, true, true]],
            ['s', 'second', [false, false, false, false, false, true]],
        ];
        $activeModifierPointer = 0;

        $diff = $dateStart->diff($dateEnd); // Holds y, m, d, h, i, s
        $diffMsg = '';

        // Assemble the message
        foreach ($diffMsgModifiers as $idx => $diffMsgModifier) {
            $cn = $diffMsgModifier[0]; // Carbon notation
            $rn = $diffMsgModifier[1]; // Readable notation
            $namv = $diffMsgModifiers[$activeModifierPointer][2]; // Next accepted message values

            if ($namv[$idx] && $diff->$cn >= 1) {
                $diffMsg .= $diff->$cn.' '.$rn.($diff->$cn > 1 ? 's' : '').' ';
            } else {
                $activeModifierPointer += 1;
            }
        }

        return $diffMsg;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    public function supplier()
    {
        if ($this->trade_type == 'offer') {
            // An offer means the owner is supplying hydrogen
            return $this->owner();
        } else {
            // A request means the responder is supplying hydrogen
            return $this->responder();
        }
    }

    public function demander()
    {
        if ($this->trade_type == 'offer') {
            // An offer means the responder is demanding hydrogen
            return $this->responder();
        } else {
            // A request means the owner is demanding hydrogen
            return $this->owner();
        }
    }
}
