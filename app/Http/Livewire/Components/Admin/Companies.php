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
        //Get companies matching name
        $this->resultSet = $companies = Company::where('name', 'LIKE', '%' . $this->searchTerm . '%')->get();
        //TODO this is a start in a good direction to also search companies on owner email, but i've stared at this for too long now.
        //the feature can wait.
        //        $companies = Company::with(['owner' => function ($query) {
        //            $query->where('email', 'LIKE', "%mel%");
        //        }])->get();
    }

    public function render()
    {
        return view('livewire.components.admin.companies');
    }
}
