<?php

namespace App\Http\Livewire\Components\Login;

use Livewire\Component;

class ForgotPasswordComponent extends Component
{

    public $email;

    public function mount(){
        $this->email = "";
    }

    public function submit(){
        $this->redirect(route('login'));
    }


    public function render()
    {
        return view('livewire.components.login.forgot-password-component')->extends('layouts.app');
    }
}
