<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
