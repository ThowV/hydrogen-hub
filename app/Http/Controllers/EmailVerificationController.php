<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function destroy(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'user' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user);
        $user->update([
            'email' => $request->email,
            'email_verified_at' => now(),
        ]);

        return response()->view('employee.email.change-complete');
    }
}
