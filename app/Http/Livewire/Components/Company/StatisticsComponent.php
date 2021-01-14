<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\Company;
use Livewire\Component;

class StatisticsComponent extends Component
{
    /**
     * @var Company|mixed
     */
    public $company;

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.components.company.statistics-component');
    }
}
