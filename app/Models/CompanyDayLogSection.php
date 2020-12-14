<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDayLogSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'produce',
        'demand',
        'store'
    ];

    public function companyDayLog()
    {
        return $this->belongsTo(CompanyDayLog::class);
    }
}
