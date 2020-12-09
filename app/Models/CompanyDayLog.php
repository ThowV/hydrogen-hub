<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CompanyDayLog
 *
 * @property int $id
 * @property int $company_id
 * @property int $produced
 * @property int $demand
 * @property int $stored
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereDemand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereProduced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereStored($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyDayLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyDayLog extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
