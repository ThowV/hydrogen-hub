<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\RegistrationRequest
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_admin_email
 * @property string $company_admin_first_name
 * @property string $company_admin_last_name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|RegistrationRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereCompanyAdminEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereCompanyAdminFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereCompanyAdminLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|RegistrationRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RegistrationRequest withoutTrashed()
 * @mixin \Eloquent
 */
class RegistrationRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "company_name",
        "company_admin_email",
        "company_admin_first_name",
        "company_admin_last_name",
    ];

    public function accept()
    {
        $this->status = 1;
        $this->save();
    }

    public function deny()
    {
        $this->delete();
        //maybe notify user
    }
}
