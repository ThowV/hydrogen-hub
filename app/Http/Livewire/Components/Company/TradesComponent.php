<?php

namespace App\Http\Livewire\Components\Company;

use App\Models\User;
use Livewire\Component;

class TradesComponent extends Component
{
    public $trades;

    public function getTrades()
    {
        $this->trades = auth()->user()->company->trades;
    }

    public function getUserName($id)
    {
        $user = User::where('id', $id)->first();
        return $user->first_name . ' ' . $user->last_name;
    }

    public function mount()
    {
        $this->getTrades();
    }

    public function render()
    {
        return view('livewire.components.company.trades-component');
    }
}
