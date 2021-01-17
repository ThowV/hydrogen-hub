<?php

namespace App\Http\Livewire\Components\Company;

use App\Events\PermissionDenied;
use App\Http\Livewire\Components\Traits\ChartBuilderTrait;
use App\Models\CompanyDayLog;
use App\Models\CompanyDayLogSection;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChartExpandedInfoComponent extends Component
{
    use ChartBuilderTrait;

    public $editState = false;
    public $password;

    public $chartType = '';
    public $datetime = '';
    public $date = null;
    public $demand = 0;
    public $store = 0;
    public $produce = 0;
    public $totalLoad = 0;
    public $sold = 0;
    public $bought = 0;
    public $position = 0;
    public $runningTradesBought = [];
    public $runningTradesSold = [];

    protected $listeners = ['showChartPointInfo' => 'showChartPointInfo', 'closeChartExpandedModal' => 'toggleEditState'];

    protected $rules = [
        'demand' => 'required|integer|min:-1000000000000|max:1000000000000',
        'store' => 'required|integer|min:-1000000000000|max:1000000000000',
        'produce' => 'required|integer|min:0|max:1000000000000',
        'password' => 'required'
    ];

    public function showChartPointInfo($xIndex, $chartData) {
        $this->editState = false;

        // Set the pre-calculated data values
        $this->chartType = $chartData['hydrogenType'];
        $this->datetime = $chartData['labels'][$xIndex];
        $this->demand = $chartData['demand'][$xIndex];
        $this->store = -$chartData['store'][$xIndex];
        $this->produce = $chartData['produce'][$xIndex];
        $this->totalLoad = $chartData['totalLoad'][$xIndex];
        $this->sold = $chartData['sold'][$xIndex];
        $this->bought = $chartData['bought'][$xIndex];

        // Set the date value
        $this->date = Carbon::create(explode('-', $this->datetime)[0]);

        // Set the to be calculated data values
        if ($this->demand != 0 && $this->totalLoad != 0) {
            if ($this->demand > $this->totalLoad) {
                $this->position = 100 - round(($this->totalLoad / $this->demand) * 100);
            }
            else {
                $this->position = 100 + round(($this->demand / $this->totalLoad) * 100);
            }
        }

        // Get the running contracts
        $start = Carbon::create(str_replace('-', '', $this->datetime));
        $this->runningTradesBought = auth()->user()->company->getBoughtTradesAfterCarbonDate($start)->where('hydrogen_type', $chartData['hydrogenType']);
        $this->runningTradesSold = auth()->user()->company->getSoldTradesAfterCarbonDate($start)->where('hydrogen_type', $chartData['hydrogenType']);
    }

    public function openTradeEntry(Trade $trade)
    {
        $this->emit('openTradeAndListingInfoModal', $trade);
    }

    public function toggleEditState($forcedState = null)
    {
        if ($this->editState == false && ! auth()->user()->can('company.fund.update')) {
            \event(new PermissionDenied());

            return back();
        }

        if (!is_bool($forcedState)) {
            $this->editState = !$this->editState;
        }
        else {
            $this->editState = $forcedState;
        }

        if (!$this->editState) {
            $this->fill(['password' => '']);
            $this->clearValidation(['password']);
        }
    }

    public function saveEdits()
    {
        // Validate input
        $this->validate();

        // Validate password
        if (! Auth::attempt(["email" => auth()->user()->email, "password" => $this->password])) {
            return $this->addError('password', 'Password is invalid.');
        }

        // Get or create the day log
        $dayLog = auth()->user()->company->dayLogs->where('date', '=', $this->date->toDateString())->first(); // Get first because faker generates multiple day logs with the same date, normally this isn't possible

        if (!$dayLog) {
            // Create a day log
            $dayLog = CompanyDayLog::create([
                'company_id' => auth()->user()->company->id,
                'date' => $this->date->toDateString(),
            ]);
            $dayLog->save();
        }

        // Get or create the company day log section
        if (!$dayLog->sections->isEmpty() && !$dayLog->sections->where('hydrogen_type', '=', $this->chartType)->isEmpty()) {
            $section = $dayLog->sections->where('hydrogen_type', '=', $this->chartType)->first();
        }
        else {
            // Create a day log section
            $section = CompanyDayLogSection::create([
                'company_day_log_id' => $dayLog->id,
                'hydrogen_type' => $this->chartType,
                'demand' => 0,
                'produce' => 0,
                'store' => 0
            ]);
        }

        // Validate permissions
        if (auth()->user()->can('company.demand.update')) {
            $section->demand = (int)((int)$this->demand * 24);
        }

        if (auth()->user()->can('company.produced.update')) {
            $section->produce = (int)((int)$this->produce * 24);
        }

        if (auth()->user()->can('company.stored.update')) {
            $section->store = (int)((int)$this->store * 24);
        }

        $section->save();
        $this->toggleEditState();
        $this->emit('chartDataModifed');
    }

    public function render()
    {
        return view('livewire.components.company.chart-expanded-info-component');
    }
}
