<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
