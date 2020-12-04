<?php


namespace App\Actions;

use App\CompanyNameNotUniqueException;
use App\Exceptions\EmailNotUniqueException;
use App\Models\Company;
use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateCompanyAction
{
    public function execute(RegistrationRequest $registration_request)
    {
        DB::transaction(function () use ($registration_request) {
            if (Company::whereName($registration_request->company_name)->first()) {
                throw new CompanyNameNotUniqueException();
            }

            if (User::whereEmail($registration_request->company_admin_email)->first()) {
                throw new EmailNotUniqueException();
            }

            $company = Company::create([
                'name' => $registration_request->company_name,
                'owner_id' => ($user = User::create([
                    "first_name" => $registration_request->company_admin_first_name,
                    "last_name" => $registration_request->company_admin_last_name,
                    "email" => $registration_request->company_admin_email,
                    "password" => Hash::make(Str::random(8)),
                ]))->id,
                //           ->sendWelcomeNotification(now()->addDay());;
            ]);
            $user->company_id = $company->id;
            $user->save();
        });

        return $registration_request->accept();
    }
}
