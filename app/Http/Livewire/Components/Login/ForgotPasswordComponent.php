<?php

namespace App\Http\Livewire\Components\Login;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPasswordComponent extends Component
{
    public $email;
    public $status;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function mount()
    {
        $this->email = "";
        $this->status = null;
    }

    public function submit()
    {
        $this->validate();

        $status = Password::sendResetLink(
            ["email" => $this->email]
        );

        $this->status = Password::RESET_LINK_SENT ?
        "Password reset link has been sent to your email" :
        $this->addError('errors', 'We had some trouble sending the reset link to your mail, please try again later');
    }

    public function render()
    {
        return view('livewire.components.login.forgot-password-component')->extends('layouts.app');
    }
}
