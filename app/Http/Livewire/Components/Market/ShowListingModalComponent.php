<?php

namespace App\Http\Livewire\Components\Market;

use App\Events\PermissionDenied;
use App\Http\Livewire\Components\Market\Traits\MarketChartBuilderTrait;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use App\Models\Trade;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShowListingModalComponent extends Component
{
    use ChartBuilderTrait, MarketChartBuilderTrait;

    public $isOpen = false;
    public $confirmationStage = false;
    public $password;
    public $tradeAble = false;
    public $chartData = [];
    public $trade;

    protected $rules = [
        'password' => 'required'
    ];

    protected $listeners = ['openRespondModal' => 'openListing'];

    public function openListing(Trade $trade)
    {
        $this->trade = $trade;
        $this->toggleModal();

        // Check if we have enough fund
        if ($trade->trade_type == "offer" && auth()->user()->company->usable_fund >= $trade->getTotalPriceAttribute()) {
            $this->tradeAble = true;
        }
        else if ($trade->trade_type == "request") {
            $this->tradeAble = true;
        }
        else {
            $this->tradeAble = false;
        }

        // Get the chart types
        $chartType = $trade->hydrogen_type;

        // Determine the period
        $tradePeriod = CarbonPeriod::create(Carbon::now(), $trade->end_raw);

        // Build the chart data
        $this->buildChart($tradePeriod, $chartType);

        // Determine the impact
        foreach ($tradePeriod as $index => $day) {
            // Get the impact
            $impact = (int)$trade->getUnitsAtCarbonDate($day);

            if ($trade->trade_type == "request") {
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
        if($trade->owner_id != auth()->id()) {
            $this->emit('listingOpened', $this->chartData[$chartType]);
        }
    }

    public function toggleConfirmationStage()
    {
        $this->confirmationStage = !$this->confirmationStage;

        if (!$this->confirmationStage) {
            $this->emit('listingOpened', $this->chartData[$this->trade->hydrogen_type]);
        }
    }

    public function makeTrade()
    {
        // Validate permission
        if (($this->trade->trade_type == "offer" && !auth()->user()->can('listings.buy'))
            || ($this->trade->trade_type == "request") && !auth()->user()->can('listings.sellto')) {
            $this->toggleModal();
            $this->toggleConfirmationStage();
            \event(new PermissionDenied());

            return back();
        }

        // Validate if we can carry out this trade
        if (!$this->tradeAble) {
            return;
        }

        // Validate password input
        $this->validate();
        if (!\Hash::check($this->password, auth()->user()->getAuthPassword())) {
            return $this->addError('password', 'Password is invalid.');
        }

        // Deduct the total price
        if ($this->trade->trade_type == "offer") {
            auth()->user()->company->usable_fund -= $this->trade->getTotalPriceAttribute();
        }
        else if ($this->trade->trade_type == "request") {
            auth()->user()->company->usable_fund += $this->trade->getTotalPriceAttribute();
        }

        auth()->user()->company->save();

        // Update trade to create deal
        $this->trade->responder_id = auth()->id();
        $this->trade->deal_made_at = now();

        // Finalize
        $this->trade->save();
        $this->emit('tradeMade');

        $this->toggleModal();
        $this->toggleConfirmationStage();
        return redirect()->to('/company/portfolio');
    }

    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.market.show-listing-modal-component');
    }
}
