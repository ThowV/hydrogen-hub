<?php

namespace App\Http\Livewire\Components\Employees;

use App\Actions\StartUpdateUserEmailAction;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $employee;

    protected $rules = [
        'employee.first_name' => 'required',
        'employee.last_name' => 'required',
        'employee.email' => 'required|email:rfc|unique:users,email',
    ];

    public function save(StartUpdateUserEmailAction $action)
    {
        $this->rules['employee.email'] .= ','.$this->employee->id;
        $this->validate();
        $this->maybeStartChangeEmailProcedure($action);
        $this->employee->save();
        $this->mount($this->employee);
    }

    protected function maybeStartChangeEmailProcedure($action)
    {
        if ($this->getStoredEmailForUser() !== $this->employee->email) {
            $action->execute($this->employee->email);
            $this->employee->email = $this->getStoredEmailForUser();
        }
    }

    /**
     * We use a query here instead of accessing the property directly, because this model state may differ from the database.
     * You could defend this by saying: "we can use the auth helper to get currently authenticated user, that might add
     * unexpected behaviour though. For example when an admin is going to be able to impersonate a user.
     *
     * @return mixed
     */
    private function getStoredEmailForUser()
    {
        return User::find($this->employee->id)->email;
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
