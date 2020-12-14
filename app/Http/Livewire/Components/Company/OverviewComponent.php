<?php

namespace App\Http\Livewire\Components\Company;

use App\Actions\StartUpdateUserEmailAction;
use App\Models\User;
use Livewire\Component;

class OverviewComponent extends Component
{
    public $employees;
    public $updateMode;
    public $employeeToUpdate;
    public $modalOpen;

    protected $rules = [
        'employeeToUpdate.first_name' => 'required',
        'employeeToUpdate.last_name' => 'required',
        'employeeToUpdate.email' => 'required',
        'employeeToUpdate.picture_url' => 'required|sometimes',
        'employeeToUpdate.created_at' => 'required',
    ];

    public function toggleModal(User $user = null)
    {
        $this->modalOpen = !$this->modalOpen;
        if ($user) {
            $this->employeeToUpdate = $user;
        }
    }

    public function saveUpdate(StartUpdateUserEmailAction $action)
    {
        $this->validate();
        $this->maybeStartChangeEmailProcedure($action);
        $this->employeeToUpdate->save();
        $this->mount();
    }

    protected function maybeStartChangeEmailProcedure($action)
    {
        if ($this->getStoredEmailForUser() !== $this->employeeToUpdate->email) {
            $action->execute($this->employeeToUpdate->email);
            $this->employeeToUpdate->email = $this->getStoredEmailForUser();
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
        return User::find($this->employeeToUpdate->id)->email;
    }

    public function getEmployees()
    {
        $this->employees = auth()->user()->company->employees;
    }

    public function mount()
    {
        $this->modalOpen = false;
        $this->getEmployees();
    }

    public function render()
    {
        return view('livewire.components.company.overview-component');
    }
}
