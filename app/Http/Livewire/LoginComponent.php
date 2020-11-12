<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{

    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|exists:users,email',
        'password' => 'required',
    ];

    public function mount()
    {
        if (Auth::check()) {
            $this->redirect(route('home'));
        }
    }

    public function submit()
    {
        $data = collect($this->validate());
        if (!Auth::attempt(["email" => $this->email, "password" => $this->password])) {
            return $this->addError('credentials', 'The credentials you supplied are invalid');
        }

        return $this->redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.login-component')->extends('layouts.app');
    }
}
