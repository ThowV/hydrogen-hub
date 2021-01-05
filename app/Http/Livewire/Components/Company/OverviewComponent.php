<?php

namespace App\Http\Livewire\Components\Company;

use App\Actions\BindRoleToUserAction;
use App\Actions\StartUpdateUserEmailAction;
use App\CreateEmployeeAction;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class OverviewComponent extends Component
{
    public $employees;
    public $updateMode;
    public $employeeToUpdate;
    public $modalOpen;
    public $addEmployeeModalOpen;
    public $employeeToCreate;

    protected $rules = [
        'employeeToUpdate.first_name' => 'sometimes|required',
        'employeeToUpdate.last_name' => 'sometimes|required',
        'employeeToUpdate.email' => 'sometimes|required',
        'employeeToUpdate.picture_url' => 'required|sometimes|sometimes',
        'employeeToUpdate.created_at' => 'sometimes|required',
        'employeeToCreate.first_name' => 'sometimes|required',
        'employeeToCreate.last_name' => 'sometimes|required',
        'employeeToCreate.email' => 'sometimes|required|email:rfc',
        'employeeToCreate.roles' => 'sometimes|required',

    ];

    public function toggleEmployeeCreationModal()
    {
        $this->addEmployeeModalOpen = !$this->addEmployeeModalOpen;
    }

    public function submitCreateUser(
        StartUpdateUserEmailAction $emailAction,
        BindRoleToUserAction $bindRoleToUserAction,
        CreateEmployeeAction $employeeAction
    ) {
        $data = $this->validate()['employeeToCreate'];
        $data['company_id'] = auth()->user()->company_id;
        $emailAction->execute($data['email']);
        if ($id = $employeeAction->execute($data)) {
            $bindRoleToUserAction->execute($data['roles'], $id);
            session()->flash('message', ['green', 'Account has been created!']);
            return $this->mount();
        } else {
            session()->flash('message', ['red', 'Account has not been created!']);
            return $this->mount();
        }
    }

    public function getRoleDisplayProperty()
    {
        return Role::where('name', '!=', 'Super Admin')->get();
    }


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
        $this->addEmployeeModalOpen = false;
        $this->modalOpen = false;
        $this->getEmployees();
    }

    public function render()
    {
        return view('livewire.components.company.overview-component');
    }
}
