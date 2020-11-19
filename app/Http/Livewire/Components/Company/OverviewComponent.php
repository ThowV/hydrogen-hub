<?php

namespace App\Http\Livewire\Components\Company;

use Livewire\Component;

class OverviewComponent extends Component
{

    public $employees;

    public function mount()
    {
        $this->employees = auth()->user()->company->employees;
    }

    public function render()
    {
        return view('livewire.components.company.overview-component');
    }
}
