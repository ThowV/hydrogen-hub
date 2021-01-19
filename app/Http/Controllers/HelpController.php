<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;


class HelpController extends Controller
{
    public function show()
    {
        return view('help.index');
    }
}
