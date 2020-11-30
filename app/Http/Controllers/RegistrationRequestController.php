<?php

namespace App\Http\Controllers;

use App\Actions\CreateCompanyAction;
use App\Events\PermissionDenied;
use App\Mail\CompanyAccepted;
use App\Mail\CompanyDenied;
use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class RegistrationRequestController extends Controller
{
    public function accept(RegistrationRequest $registrationRequest, CreateCompanyAction $action)
    {
        if (!auth()->user()->can('request.allow')) {
            \event(new PermissionDenied());
            return back();
        }

        $action->execute($registrationRequest);
        Password::sendResetLink(
            ["email" => $registrationRequest->company_admin_email]
        );
        Mail::to($registrationRequest->company_admin_email)->send(new CompanyAccepted());

        return back();
    }

    public function deny(RegistrationRequest $registrationRequest)
    {
        if (!auth()->user()->can('request.deny')) {
            $registrationRequest->deny();
            \event(new PermissionDenied());
            return back();
        }

        $registrationRequest->deny();
        Mail::to($registrationRequest->company_admin_email)->send(new CompanyDenied());

        return back();
    }
}
