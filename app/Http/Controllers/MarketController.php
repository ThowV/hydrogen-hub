<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class MarketController extends Controller
{
    public function show()
    {
        return view('market');
    }
}
