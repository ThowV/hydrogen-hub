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
        'price_per_unit',
        'mix_co2',
        'duration',
        'expires_at',
    ];

    public function close()
    {
        $this->open = false;
        $this->save();
    }

    public function reopen()
    {
        $this->open = true;
        $this->save();
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
