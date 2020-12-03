<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use ReceivesWelcomeNotification;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'picture_url',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isOwnerOf()
    {
        return $this->hasOne(Company::class, 'owner_id');
    }

    public function tradesAsResponder()
    {
        return $this->hasMany(Trade::class, 'responder_id');
    }

    public function tradesAsOwner()
    {
        return $this->hasMany(Trade::class, 'owner_id')->whereNotNull('responder_id');
    }

    public function getTradesAttribute()
    {
        return $this->tradesAsResponder->merge($this->tradesAsOwner);
    }

    public function listings()
    {
        return $this->hasMany(Trade::class, 'owner_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getAvatarAttribute()
    {
        return $this->picture_url ?? "https://placehold.it/50x50";
    }
}
