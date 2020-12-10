<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleManagerComponent extends Component
{

    public $roles;

    public function mount()
    {
        //User should be able to change roles
        if(!auth()->user()->can('employees.roles.update')){
            return;
        }
        //Get roles
        $this->roles = Role::where('name','!=','Super Admin')->get();

    }

    public function render()
    {
        return view('livewire.components.admin.role-manager-component')->extends('layouts.app');
    }
}
