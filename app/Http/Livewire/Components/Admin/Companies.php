<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Company;
use Livewire\Component;

class Companies extends Component
{
    public $resultSet;
    public $searchTerm;

    public function mount()
    {
        if (empty($this->searchTerm)) {
            $this->resultSet = Company::all();
            $this->searchTerm = "";
        }
    }

    public function updated()
    {
        $this->searchTerm = htmlspecialchars($this->searchTerm);

        $this->resultSet = Company::where('name', 'LIKE', "%$this->searchTerm%")->get()->merge(
            Company::whereHas('owner', function ($query) {
                 $query->where('email', 'LIKE', "%$this->searchTerm%");
             })->get()
        );
    }

    public function render()
    {
        return view('livewire.components.admin.companies');
    }
}
