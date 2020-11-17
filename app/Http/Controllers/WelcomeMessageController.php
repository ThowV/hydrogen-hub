<?php


namespace App\Http\Controllers;

use Spatie\WelcomeNotification\WelcomeController as BaseWelcomeController;

class WelcomeMessageController extends BaseWelcomeController
{


    public function showWelcomeForm()
    {
        return view('welcomeNotification::welcome');
    }


}
