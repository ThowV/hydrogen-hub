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
}
