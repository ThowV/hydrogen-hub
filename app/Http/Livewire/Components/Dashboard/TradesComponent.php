<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class TradesComponent extends Component
{
    public $trades;

    public function getTrades()
    {
        $this->trades = Trade::where('responder_id', '!=', null)->get();
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
