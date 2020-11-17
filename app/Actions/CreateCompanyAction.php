<?php


namespace App;


use App\Models\Company;
use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateCompanyAction
{

    /**
     * CreateCompanyAction constructor.
     */
    public function __construct(RegistrationRequest $registration_request)
    {
        $this->registration_request = $registration_request;
    }

    public function execute()
    {

        DB::transaction(function () {

            $company = Company::create([
                'name' => $this->registration_request->company_name,
                'owner_id' => ($user = User::create([
                    "first_name" => $this->registration_request->company_admin_first_name,
                    "last_name" => $this->registration_request->company_admin_last_name,
                    "email" => $this->registration_request->company_admin_email,
                    "password" => Hash::make(Str::random(8))
                ]))->id,
                //           ->sendWelcomeNotification(now()->addDay());;
            ]);

            $user->company_id = $company->id;
            $user->save();
        });

        return $this->registration_request->accept();
    }
}
