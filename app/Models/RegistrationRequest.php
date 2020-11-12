<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_name",
        "company_email",
        "company_admin_first_name",
        "company_admin_last_name"
    ];
}
