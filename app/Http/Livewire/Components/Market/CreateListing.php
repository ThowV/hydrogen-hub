<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class CreateListing extends Component
{
    public $trade_type;
    public $hydrogen_type;
    public $units_per_hour;
    public $duration;
    public $price_per_unit;
    public $mix_co2;
    public $expires_at;

    // Default select does not work with livewire at the moment:
    public $duration_type = "day";
    public $expires_at_type = "day";

    protected $rules = [
        'trade_type' =>     'required',
        'hydrogen_type' =>  'required',
        'units_per_hour' => 'required|numeric|min:0|max:1000000',
        'duration' =>       'required|numeric',
        'price_per_unit' => 'required|numeric|min:0|max:1000000',
        'mix_co2' =>        'required|numeric|min:0|max:100',
        'expires_at' =>     'required|numeric',
    ];

    public function render()
    {
        return view('livewire.components.market.create-listing');
    }

    private function refresh()
    {
        // Empty/reset all fields
        $this->fill([
            'trade_type'        => '',
            'hydrogen_type'     => '',
            'units_per_hour'    => '',
            'duration_type'     => 'day',
            'price_per_unit'    => '',
            'mix_co2'           => '',
            'expires_at'        => '',
            'expires_at_type'   => 'day'
        ]);
    }

    public function submit()
    {
        $data = $this->validate();

        // Add owner_id value to data
        $data['owner_id'] = auth()->id();

        // Modify duration data
        $duration = $data['duration'] * 24;

        $now = Carbon::now();
        $end = $now->copy();

        if ($this->duration_type == 'day') {
            $end->addDays($data['duration']);
        }
        elseif ($this->duration_type == 'week') {
            $end->addWeeks($data['duration']);
        }
        elseif ($this->duration_type == 'month') {
            $end->addMonths($data['duration']);
        }

        $hoursDiff = $now->diffInHours($end);
        $data['duration'] = $hoursDiff;

        // Modify expires at data
        $data['expires_at'] = now()->add($data['expires_at'], $this->expires_at_type);

        // Create trade
        Trade::create($data);

        // Emit an event telling the parent component that the listing has been created
        $this->emit('listingCreated');

        // Refresh the form
        $this->refresh();
    }
}
