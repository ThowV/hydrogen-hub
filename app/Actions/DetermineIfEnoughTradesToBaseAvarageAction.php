<?php


namespace App\Actions;


use App\Models\Trade;

class DetermineIfEnoughTradesToBaseAvarageAction
{

    public static function execute($limit = 10)
    {
        return Trade::where('responder_id', '!=', null)->count() > $limit;
    }
}
