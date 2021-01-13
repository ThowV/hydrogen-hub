<?php

namespace App\Http\Livewire\Components\Market;

use App\Http\Livewire\Components\Market\Traits\MarketChartBuilderTrait;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use App\Models\Trade;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

class CreateListingModalComponent extends Component
{
    use ChartBuilderTrait, MarketChartBuilderTrait;

    public $isOpen = false;
    public $confirmationStage = false;
    public $chartData = [];

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
        'units_per_hour' => 'required|integer|min:0|max:1000000',
        'duration' =>       'required|integer|min:0|max:365',
        'price_per_unit' => 'required|integer|min:0|max:1000000',
        'mix_co2' =>        'required|integer|min:0|max:100',
        'expires_at' =>     'required|integer|min:0|max:365',
    ];

    protected $listeners = ['openCreateModal' => 'toggleModal'];

    public function composeChart() {
        // Emit the event to clear the chart on the front-end
        $this->emit('listingParametersCleared');

        if ($this->hydrogen_type == '' || $this->units_per_hour == '' || $this->duration == '' || $this->trade_type == '') {
            return;
        }

        // Modify duration data
        $duration = $this->getDuration($this->duration, $this->duration_type);

        // Determine the period
        $start = Carbon::now()->addHour()->setMinute(0)->setSecond(0);
        $period = CarbonPeriod::create($start, $start->copy()->addHours($duration));

        // Build the chart data
        $chartType = $this->hydrogen_type;
        $this->buildChart($period, $chartType);

        // Determine the impact
        foreach ($period as $index => $day) {
            // Calculate the impact
            $durationOnDay = 24;

            if ($day->diffInDays($period->start) == 0) {
                $startDayEnd = $day->copy();
                $startDayEnd->hour = 24;

                // Only a part of today the company will be provided with the units
                $durationOnDay = ceil($day->diffInMinutes($startDayEnd) / 60);
            }
            else if ($day->diffInDays($period->end) == 0) {
                $day->hour = 0;

                // Only a part of today the company will be provided with the units
                $durationOnDay = ceil($day->diffInMinutes($period->end) / 60);
            }

            $impact = (int)$this->units_per_hour * $durationOnDay;

            if ($this->trade_type == "request") {
                $impact = -$impact;
            }

            // Calculate all the values as a result of the impact
            $totalLoad = $this->chartData[$chartType]['totalLoad'][$index];
            $bounds = [$this->chartData[$chartType]['min'], $this->chartData[$chartType]['max']];

            $impactValues = $this->calculateImpactValues($totalLoad, $impact, $bounds);

            $this->chartData[$chartType]['loadLeft'][] = $impactValues['totalLoad'];
            $this->chartData[$chartType]['newTotalLoad'][] = $impactValues['newTotalLoad'];
            $this->chartData[$chartType]['loadRemoved'][] = $impactValues['loadRemoved'];
            $this->chartData[$chartType]['loadAdded'][] = $impactValues['loadAdded'];
            $this->chartData[$chartType]['min'] = $impactValues['min'];
            $this->chartData[$chartType]['max'] = $impactValues['max'];
        }

        if ($chartType != 'mix') {
            // Emit the event to initialize the chart on the front-end
            $this->emit('listingParametersFilled', $this->chartData[$chartType]);
        }
    }

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

    public function toggleModal() {
        $this->isOpen = !$this->isOpen;

        if ($this->isOpen) {
            // Emit the event to clear the chart on the front-end
            $this->emit('listingParametersCleared');
        }

        $this->refresh();
    }

    public function toggleConfirmationStage() {
        $this->validate();
        $this->confirmationStage = !$this->confirmationStage;
    }

    public function createListing() {
        $this->validate();

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

    private function getDuration($duration, $type) {
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

    public function getTotalPriceReadable() {
        if ($this->duration && $this->duration_type && $this->units_per_hour && $this->price_per_unit) {
            $total_price = $this->getDuration($this->duration, $this->duration_type) * $this->units_per_hour * $this->price_per_unit;
            return '€ ' . number_format($total_price, 0, '.', ' ');
        }

        return 'Not provided.';
    }

    public function getTotalVolumeReadable() {
        if ($this->duration && $this->duration_type && $this->units_per_hour) {
            $total_volume = $this->getDuration($this->duration, $this->duration_type) * $this->units_per_hour;
            return number_format($total_volume, 0, '.', ' ') . ' unit' . ($total_volume > 1 ? 's' : '');
        }

        return 'Not provided.';
    }

    public function getDurationReadable() {
        if ($this->duration && $this->duration_type && is_numeric($this->duration)) {
            return $this->duration . ' ' . $this->duration_type . ($this->duration > 1 ? 's' : '');
        }

        return 'Not provided.';
    }

    public function getExpiresAtReadable() {
        if ($this->expires_at && $this->expires_at_type) {
            return Carbon::now()->addHours($this->getDuration($this->expires_at, $this->expires_at_type))->toDateString();
        }

        return 'Not provided.';
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function render() {
        return view('livewire.components.market.create-listing-modal-component');
    }
}
