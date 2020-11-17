<?php

namespace App\Listeners;

use App\Events\PermissionDenied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;

class SendPermissionDeniedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PermissionDenied $event)
    {
        // Since we are probably going to send this message from a lot of different places, its a good idea to decouple
        // So this is a great place to put any logic for displaying a message about the permission being denied.
        Log::error("Permission denied");
    }
}
