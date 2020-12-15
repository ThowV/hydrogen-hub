<?php


namespace App;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;


class CreateEmployeeAction
{
    public function execute($data )
    {
        try {
            $employeeToCreate = new User($data);
            DB::transaction(function () use (&$employeeToCreate, $data) {
                $employeeToCreate->company_id = $data['company_id'];
                $employeeToCreate->password = \Hash::make('ThisIsATemporaryPasswordWhichWillImmediatelyBeInvalidated');
                $employeeToCreate->save();
                $status = Password::sendResetLink(
                    ["email" => $data['email']]
                );

            Password::RESET_LINK_SENT ? "Password reset link has been sent to your email" : $this->addError('errors', 'We had some trouble sending the reset link to your mail, please try again later');
            });

            return $employeeToCreate->id;
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
