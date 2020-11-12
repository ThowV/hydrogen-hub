<?php

namespace App\Http\Livewire\Components\Registration;

use App\Models\RegistrationRequest;
use Livewire\Component;

class Requests extends Component
{
    public $requests;

    public function mount()
    {
        $this->requests = RegistrationRequest::whereStatus(0)->get();
    }

    public function render()
    {
        return view('livewire.components.registration.requests');
    }
}
