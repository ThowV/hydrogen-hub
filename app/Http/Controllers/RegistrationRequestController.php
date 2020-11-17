<?php

namespace App\Http\Controllers;

use App\CreateCompanyAction;
use App\Models\RegistrationRequest;

class RegistrationRequestController extends Controller
{
    public function accept(RegistrationRequest $registrationRequest, CreateCompanyAction $action)
    {
        if (!auth()->user()->hasPermissionTo('request.allow')) {

            return;
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
