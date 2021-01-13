<?php

namespace App\Http\Livewire\Components\Company;

use App\Events\PermissionDenied;
use Livewire\Component;

class FinancialsComponent extends Component
{
    public $company;
    public $editState = false;
    public $usableFund;

    protected $rules = ['usableFund' => 'required|integer|min:0|max:1000000000000'];

    public function saveEdits()
    {
        $this->validate();
        
        $this->toggleEditState();

        if (! auth()->user()->can('company.fund.update')) {
            \event(new PermissionDenied());

            return back();
        }

        $this->company->usable_fund = $this->usableFund;
        $this->company->save();
    }

    public function toggleEditState()
    {
        if (! auth()->user()->can('company.fund.update')) {
            \event(new PermissionDenied());

            return back();
        }

        $this->editState = ! $this->editState;

        if ($this->editState) {
            $this->usableFund = $this->company['usable_fund'];
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
