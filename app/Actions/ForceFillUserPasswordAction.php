<?php


namespace App\Actions;


use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForceFillUserPasswordAction
{
    public function execute(User $user, $password){
        $user->forceFill([
            'password' => Hash::make($password)
        ])->save();

        $user->setRememberToken(Str::random(60));

        event(new PasswordReset($user));
    }
}
