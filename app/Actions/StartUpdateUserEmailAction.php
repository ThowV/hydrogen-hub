<?php


namespace App\Actions;

use App\Notifications\EmailChangeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class StartUpdateUserEmailAction
{
    public function execute($email)
    {
        // Send the email to the user
        Notification::route('mail', $email)
            ->notify(new EmailChangeNotification(Auth::id()));

        // Return the view
        return back()->with([
            'email_changed' => $email,
        ]);
    }
}
