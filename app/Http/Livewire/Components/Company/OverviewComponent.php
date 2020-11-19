<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\User;
use Livewire\Component;

class OverviewComponent extends Component
{

    public $employees;
    public $updateMode;
    public $employeeToUpdate;

    protected $rules = [
        'employeeToUpdate.first_name' => 'required',
        'employeeToUpdate.last_name' => 'required',
        'employeeToUpdate.email' => 'required',
        'employeeToUpdate.picture_url' => 'required',
        'employeeToUpdate.created_at' => 'required'
    ];

    protected $listeners = ["updateModeEnabled" => "updateMode"];

    public function updateMode(User $user)
    {
        $this->updateMode = true;
        $this->employeeToUpdate = $user;
    }

    public function saveUpdate()
    {
        $this->validate();
        $this->employeeToUpdate->save();
        $this->mount();
    }

    public function getEmployees()
    {
        $this->employees = auth()->user()->company->employees;
    }

    public function mount()
    {
        $this->updateMode = false;
        $this->getEmployees();
    }

    public function render()
    {
        return view('livewire.components.company.overview-component');
    }
}
