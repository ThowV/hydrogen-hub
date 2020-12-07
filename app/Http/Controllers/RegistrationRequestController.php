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

        Mail::to($registrationRequest->company_admin_email)->send(new CompanyAccepted());
        Password::sendResetLink(
            ["email" => $registrationRequest->company_admin_email]
        );
        if (false !== $action->execute($registrationRequest)) {
            return back();
        } else {
            return back()->withStatus('An error has occurred. Please try again later');
        }

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
