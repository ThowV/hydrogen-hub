<?php

namespace App\Http\Livewire\Components\Company;

use Livewire\Component;

class FinancialsComponent extends Component
{
    public $company;

    public function mount()
    {
        $this->company = auth()->user()->company;
    }

    public function render()
    {
        return view('livewire.components.company.financials-component');
    }
}
