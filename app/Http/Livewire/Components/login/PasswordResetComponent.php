<?php

namespace App\Http\Livewire\Components\Login;

use App\Actions\ForceFillUserPasswordAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PasswordResetComponent extends Component
{

    public $password;
    public $password_old;
    public $password_confirmation;

    protected $rules = [
        'password_old'=>'required|password',
        'password'=>'required|between:8,255|confirmed',
        'password_confirmation' => 'required'
    ];

    public function mount()
    {
        $this->success = false;
    }

    public $success;

    public function submit(ForceFillUserPasswordAction $action)
    {
        $this->validate();

        $action->execute(auth()->user(), $this->password);
        return $this->success = true;
    }

    public function render()
    {
        return view('livewire.components.login.password-reset-component');
    }
}
