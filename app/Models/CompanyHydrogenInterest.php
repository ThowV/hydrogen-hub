<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHydrogenInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'interest'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
