<?php

namespace App\Http\Controllers;

use App\CreateCompanyAction;

use App\Events\PermissionDenied;
use App\Models\RegistrationRequest;

class RegistrationRequestController extends Controller
{
    public function accept(RegistrationRequest $registrationRequest, CreateCompanyAction $action)
    {
        if (!auth()->user()->hasPermissionTo('request.allow')) {
            //Notify user that he has no rights to perform this action.
            \event(new PermissionDenied());
            return back();
        }
        $action->execute($registrationRequest);

        return back();
    }

    public function deny(RegistrationRequest $registration_request)
    {
        if (auth()->user()->hasPermissionTo('request.deny')) {
            $registration_request->deny();
        } else {

        }

        return back();
    }
}
