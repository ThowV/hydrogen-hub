<?php

namespace App\Http\Livewire\Components\Market;

use App\Models\Trade;
use Carbon\Carbon;
use Livewire\Component;

class CreateListingModalComponent extends Component
{
    public $isOpen = false;
    public $confirmationStage = false;

    public $trade_type;
    public $hydrogen_type;
    public $units_per_hour;
    public $duration;
    public $price_per_unit;
    public $mix_co2;
    public $expires_at;

    public $trade;

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

    protected $listeners = ['openCreateModal' => 'toggleModal'];

    private function refresh()
    {
        // Empty/reset all fields
        $this->fill([
            'trade_type'        => '',
            'hydrogen_type'     => '',
            'units_per_hour'    => '',
            'duration'          => '',
            'duration_type'     => 'day',
            'price_per_unit'    => '',
            'mix_co2'           => '',
            'expires_at'        => '',
            'expires_at_type'   => 'day'
        ]);
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
        $this->refresh();
    }

    public function toggleConfirmationStage()
    {
        if (!$this->confirmationStage) {
            $this->validate();
        }

        $this->confirmationStage = !$this->confirmationStage;
    }

    public function createListing()
    {
        $data = $this->validate();

        // Add owner_id value to data
        $data['owner_id'] = auth()->id();

        // Modify duration data
        $data['duration'] = $this->getDuration($this->duration, $this->duration_type);

        // Modify expires at data
        $data['expires_at'] = now()->add($data['expires_at'], $this->expires_at_type);

        // Create trade
        Trade::create($data);

        // Emit an event telling the parent component that the listing has been created
        $this->emit('listingCreated');

        // Hide the form
        $this->toggleConfirmationStage();
        $this->toggleModal();
    }

    private function getDuration($duration, $type)
    {
        $now = Carbon::now();
        $end = $now->copy();

        if ($type == 'day') {
            $end->addDays($duration);
        }
        elseif ($type == 'week') {
            $end->addWeeks($duration);
        }
        elseif ($type == 'month') {
            $end->addMonths($duration);
        }

        return $now->diffInHours($end);
    }

    public function getTotalPriceReadable()
    {
        if ($this->duration && $this->duration_type && $this->units_per_hour && $this->price_per_unit) {
            $total_price = $this->getDuration($this->duration, $this->duration_type) * $this->units_per_hour * $this->price_per_unit;
            return '€ ' . number_format($total_price, 0, '.', ' ');
        }

        return 'Not provided.';
    }

    public function getTotalVolumeReadable()
    {
        if ($this->duration && $this->duration_type && $this->units_per_hour) {
            $total_volume = $this->getDuration($this->duration, $this->duration_type) * $this->units_per_hour;
            return number_format($total_volume, 0, '.', ' ') . ' unit' . ($total_volume > 1 ? 's' : '');
        }

        return 'Not provided.';
    }

    public function getDurationReadable()
    {
        if ($this->duration && $this->duration_type && is_numeric($this->duration)) {
            return $this->duration . ' ' . $this->duration_type . ($this->duration > 1 ? 's' : '');
        }

        return 'Not provided.';
    }

    public function getExpiresAtReadable()
    {
        if ($this->expires_at && $this->expires_at_type)
        {
            return Carbon::now()->addHours($this->getDuration($this->expires_at, $this->expires_at_type))->toDateString();
        }

        return 'Not provided.';
    }

    public function mount()
    {
        $this->trade = new Trade();
        $this->trade->fill(['units_per_hour' => 0]);
    }

    public function render()
    {
        return view('livewire.components.market.create-listing-modal-component');
    }
}
