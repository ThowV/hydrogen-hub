<?php

namespace App\Http\Controllers;

use App\CreateCompanyAction;
use App\Models\Company;
use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationRequestController extends Controller
{
    public function accept(RegistrationRequest $registrationRequest)
    {
        //TODO create company and user model
        if (!auth()->user()->hasPermissionTo('request.allow')) {
            //give notice
            return;
        }

        (new CreateCompanyAction($registrationRequest))->execute();

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
