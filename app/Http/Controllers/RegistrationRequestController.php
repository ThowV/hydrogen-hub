<?php

namespace App\Http\Controllers;

use App\Models\RegistrationRequest;

class RegistrationRequestController extends Controller
{
    public function accept(RegistrationRequest $registration_request)
    {
        //TODO create company and user model
        if(!auth()->user()->hasPermissionTo('company.request.allow')){
            $registration_request->accept();
        }

        return back();
    }

    public function deny(RegistrationRequest $registration_request)
    {
        $registration_request->deny();

        return back();
    }
}
