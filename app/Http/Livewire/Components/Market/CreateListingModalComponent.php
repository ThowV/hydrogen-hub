<?php

namespace App\Http\Livewire\Components\Market;

use App\Events\PermissionDenied;
use App\Http\Livewire\Components\Market\Traits\MarketChartBuilderTrait;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use App\Models\Trade;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateListingModalComponent extends Component
{
    use ChartBuilderTrait, MarketChartBuilderTrait;

    public $isOpen = false;
    public $confirmationStage = false;
    public $chartData = [];
    public $disableMixCO2 = false;

    public $trade_type;
    public $hydrogen_type;
    public $units_per_hour;
    public $duration;
    public $price_per_unit;
    public $mix_co2;
    public $expires_at;

    public $password;

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
        'password' =>       'required',
    ];

    protected $listeners = ['openCreateModal' => 'toggleModal'];

    public function hydrogenTypeChanged() {
        if ($this->hydrogen_type == 'green') {
            $this->mix_co2 = 0;
            $this->disableMixCO2 = true;
        }
        else {
            $this->disableMixCO2 = false;
        }

        $this->composeChart();
    }

    public function composeChart() {
        if ($this->hydrogen_type == '' || $this->units_per_hour == '' || $this->duration == '' || $this->trade_type == '') {
            // Emit the event to clear the chart on the front-end
            $this->emit('listingParametersCleared');
            return;
        }

        // Emit the event to clear the chart on the front-end
        $this->emit('listingParametersCleared');

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

        // Emit the event to initialize the chart on the front-end
        $this->emit('listingParametersFilled', $this->chartData[$chartType]);
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
            'expires_at_type'   => 'day',
            'password'          => '',
        ]);
    }

    public function toggleModal() {
        $this->refresh();
        $this->isOpen = !$this->isOpen;

        if ($this->isOpen) {
            // Emit the event to clear the chart on the front-end
            $this->emit('listingParametersCleared');
        }
    }

    public function toggleConfirmationStage() {
        if (!$this->confirmationStage) {
            // Validate without password since this is set later
            unset($this->rules['password']);
            $this->validate();
            $this->rules['password'] = 'required';
        }

        $this->confirmationStage = !$this->confirmationStage;

        if (!$this->confirmationStage) {
            // Emit the event to initialize the chart on the front-end
            $this->emit('listingParametersFilled', $this->chartData[$this->hydrogen_type]);
        }
    }

    public function createListing() {
        // Validate permission
        if (!auth()->user()->can('listings.create')) {
            $this->toggleModal();
            $this->toggleConfirmationStage();
            \event(new PermissionDenied());

            return back();
        }

        $data = $this->validate();

        // Validate password input
        if (!\Hash::check($this->password, auth()->user()->getAuthPassword())) {
            return $this->addError('password', 'Password is invalid.');
        }

        // Add owner_id value to data
        $data['owner_id'] = auth()->id();

        // Modify duration data
        $data['duration'] = $this->getDuration($this->duration, $this->duration_type);

        // Modify expires at data
        $data['expires_at'] = now()->add($data['expires_at'], $this->expires_at_type);

        // Create trade
        $trade = Trade::create($data);
        $trade->save();

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
