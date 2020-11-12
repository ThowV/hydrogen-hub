<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class);
    }

    public function dayLogs()
    {
        return $this->hasMany(CompanyDayLog::class);
    }

    public function trades()
    {
        return $this->hasManyThrough(Trade::class, User::class, null, 'owner_id');
    }
}
