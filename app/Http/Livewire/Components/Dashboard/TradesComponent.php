<?php

namespace App\Http\Livewire\Components\Dashboard;

use Carbon\Carbon;
use Livewire\Component;

class TradesComponent extends Component
{
    public $trades;

    public function getTrades()
    {
        $this->trades = auth()->user()->company->trades;
    }

    public function getTimePassedSinceDate($date)
    {
        $date = Carbon::parse($date);
        $now = Carbon::now();
        $end = $now->copy()->addHours(1200);
        return $now->toDateString() . ' - ' . $date->toDateString() . ' - ' . $end->diffForHumans($now);
    }

    public function mount()
    {
        $this->getTrades();
    }

    public function render()
    {
        return view('livewire.components.dashboard.trades-component');
    }
}
