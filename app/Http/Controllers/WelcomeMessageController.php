<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Spatie\WelcomeNotification\WelcomeController as BaseWelcomeController;

class WelcomeMessageController extends BaseWelcomeController
{


    public function showWelcomeForm(Request $request, User $user)
    {
        return view('welcomeNotification::welcome');
    }


}
