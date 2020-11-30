<?php

namespace App\Http\Livewire\Components\Company;

use Livewire\Component;

class FinancialsComponent extends Component
{
    public $company;
    public $editState = false;
    public $usableFund;

    public function saveEdits()
    {
        if (auth()->user()->can('company.portfolio.write')) {
            $this->company->usable_fund = $this->usableFund;
            $this->company->save();
        }

        $this->toggleEditState();
    }

    public function toggleEditState()
    {
        if (auth()->user()->can('company.portfolio.write')) {
            $this->editState = !$this->editState;

            if ($this->editState) {
                $this->usableFund = $this->company['usable_fund'];
            }
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
