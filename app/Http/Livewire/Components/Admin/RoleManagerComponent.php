<?php

namespace App\Http\Livewire\Components\Admin;

use App\Events\PermissionDenied;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleManagerComponent extends Component
{

    public $roles;
    public $user;
    public $roleInputs = [];
    protected $rules = [];

    public function mount(User $user)
    {
        //User should be able to change roles `
        $this->dodgeIfUserDoesNotHavePermissionToChangeRoles();
        $this->dodgeIfUserDoesNotBelongToCompany();

        $this->roles = Role::where('name', '!=', 'Super Admin')->get();
        $this->user = $user;
    }

    private function dodgeIfUserDoesNotHavePermissionToChangeRoles()
    {
        if (!auth()->check() || !auth()->user()->can('employees.roles.update')) {
            event(new PermissionDenied());
            return $this->redirect(route('home'));
        }
    }

    private function dodgeIfUserDoesNotBelongToCompany($user)
    {
        if ($user->company_id !== auth()->user()->company_id) {
            event(new PermissionDenied());
            return $this->redirect(route('home'));
        }
    }

    public function syncRolesFromInputs()
    {
        if ($this->user->hasRole('Super Admin')) {
            $this->roleInputs[] = "Super Admin";
        } else {
            $this->removeSuperAdminFromListIfNotAllowed();
        }

        $this->user->syncRoles($this->roleInputs);
        $this->user->save();
    }

    private function removeSuperAdminFromListIfNotAllowed()
    {
        if (($key = array_search("Super Admin", $this->roleInputs)) !== false) {
            unset($this->roleInputs[$key]);
        }
    }

    public function updated()
    {
        $this->syncRolesFromInputs();
    }

    public function render()
    {
        return view('livewire.components.admin.role-manager-component')->extends('layouts.app');
    }
}
