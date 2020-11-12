<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "company_name",
        "company_admin_email",
        "company_admin_first_name",
        "company_admin_last_name"
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
