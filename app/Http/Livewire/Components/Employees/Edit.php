<?php

namespace App\Http\Livewire\Components\Employees;

use App\Models\User;
use Livewire\Component;
use Log;

class Edit extends Component
{
    public $employee;

    protected $rules = [
        'employee.first_name' => 'required',
        'employee.last_name' => 'required',
        'employee.email' => 'required',
        'employee.picture_url' => 'required',
    ];

    public function save()
    {
        $this->employee->save();
        $this->mount($this->employee);
    }


    public function updatedEmployeeEmail()
    {
        Log::info('email updated');
    }


    public function mount(User $employee)
    {
        $this->employee = $employee;
    }

    public function render()
    {
        return view('livewire.components.employees.edit');
    }
}
