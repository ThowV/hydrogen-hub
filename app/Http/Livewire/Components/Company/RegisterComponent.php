<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\RegistrationRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RegisterComponent extends Component
{
    public $company_name;
    public $company_admin_email;
    public $company_backup_email;
    public $company_phone_number;
    public $company_admin_last_name;
    public $company_admin_first_name;
    public $success;

    protected $rules = [
        "company_name" => "required|unique:companies,name|unique:registration_requests,company_name",
        "company_admin_email" => "required|unique:registration_requests,company_admin_email",
        "company_admin_last_name" => "required",
        "company_admin_first_name" => "required",
        "company_backup_email" => "required|unique:registration_requests",
        "company_phone_number" => "required|unique:registration_requests,company_phone_number",
    ];

    public function mount()
    {
        $this->success = false;
    }

    public function submit()
    {
        $data = $this->validate();

        try {
            RegistrationRequest::create($data);
        } catch (Exception $exception) {
            $this->addError('error', 'Something went wrong. Please try again later');
            Log::error('Encountered an error while trying to create registration request: '. $exception->getMessage());

            return $this->success = false;
        }

        return $this->success = true;
    }

    public function render()
    {
        return view('livewire.components.company.register')->extends('layouts.app');
    }
}
