<?php

namespace App\Http\Controllers;

use App\CreateCompanyAction;

use App\Events\PermissionDenied;
use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Log;

class RegistrationRequestController extends Controller
{
    public function accept(RegistrationRequest $registrationRequest, CreateCompanyAction $action)
    {
        if (!auth()->user()->can('request.allow')) {
            //Notify user that he has no rights to perform this action.
            \event(new PermissionDenied());
            return back();
        }
        $action->execute($registrationRequest);

        return back();
    }

    public function deny(RegistrationRequest $registration_request)
    {
        if (!auth()->user()->can('request.deny')) {
            $registration_request->deny();
            \event(new PermissionDenied());
            return back();
        }

        $registration_request->deny();

        return back();
    }
}
