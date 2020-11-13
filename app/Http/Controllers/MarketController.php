<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Routing\Controller;

class MarketController extends Controller
{
    public function index()
    {
        return view('market.index', [
            'trades' => Trade::latest()->paginate(10)
        ]);
    }

    public function show(Trade $trade)
    {
        return view('market.show', [
            'trade' => $trade
        ]);
    }
}
