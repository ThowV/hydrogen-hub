<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Company;
use Livewire\Component;

class Companies extends Component
{
    public $resultSet;
    public $searchTerm;
    public $modalOpen;
    public $companyInModal;

    public function mount()
    {
        $this->companyInModal = null;
        if (empty($this->searchTerm)) {
            $this->resultSet = Company::all();
            $this->searchTerm = "";
        }
    }

    public function toggleModal(Company $company = null)
    {
        $this->modalOpen = !$this->modalOpen;
        if (!$company->exists) {
            return;
        }

        $this->companyInModal = $company;
    }

    public function updatedSearchTerm()
    {
        $this->searchTerm = htmlspecialchars($this->searchTerm);
        if($this->searchTerm == ""){
            $this->resultSet = Company::all();
            return;
        }

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
