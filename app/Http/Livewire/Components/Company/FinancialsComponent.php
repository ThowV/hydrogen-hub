<?php

namespace App\Http\Livewire\Components\Company;

use App\Events\PermissionDenied;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FinancialsComponent extends Component
{
    public $company;
    public $editState = false;
    public $usableFund;
    public $password;

    protected $rules = [
        'usableFund' => 'required|integer|min:0|max:1000000000000',
        'password' => 'required'
    ];

    public function saveEdits()
    {
        // Validate permission
        if (! auth()->user()->can('company.fund.update')) {
            $this->toggleEditState();
            \event(new PermissionDenied());

            return back();
        }

        // Validate input
        $this->validate();

        // Validate password
        if (! Auth::attempt(["email" => auth()->user()->email, "password" => $this->password])) {
            return $this->addError('password', 'Password is invalid.');
        }

        $this->toggleEditState();
        $this->company->usable_fund = $this->usableFund;
        $this->company->save();
    }

    public function toggleEditState()
    {
        if (! auth()->user()->can('company.fund.update')) {
            \event(new PermissionDenied());

            return back();
        }

        $this->editState = !$this->editState;

        if ($this->editState) {
            $this->usableFund = $this->company['usable_fund'];
        }
        else {
            $this->fill(['password' => '']);
            $this->clearValidation(['password']);
        }
    }

    public function mount()
    {
        $this->company = auth()->user()->company;
    }

    public function render()
    {
        return view('livewire.components.company.financials-component');
    }
}
