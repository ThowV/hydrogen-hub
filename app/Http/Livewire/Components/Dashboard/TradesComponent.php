<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class TradesComponent extends Component
{
    public $trades;

    public function mount()
    {
        $this->trades = Trade::where('responder_id', '!=', null)->orderByDesc('deal_made_at')->limit(15)->get();
    }

    public function render()
    {
        return view('livewire.components.dashboard.trades-component');
    }
}
