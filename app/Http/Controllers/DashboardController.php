<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        return view('dashboard.index');
    }
}
