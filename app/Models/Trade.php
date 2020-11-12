<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

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
