<?php

namespace App\Http\Controllers;

use App\Actions\ForceFillUserPasswordAction;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Str;

class PasswordResetsController extends Controller
{

    public function showForm(Request $request)
    {
        return view('password.reset-password');
    }

    public function resetPassword(Request $request, ForceFillUserPasswordAction $action)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($action, $request) {
                $action->execute($user,$password);
            }
        );


        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
