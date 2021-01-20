<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Actions\DetermineIfEnoughTradesToBaseAvarageAction;
use App\Http\Livewire\Components\Dashboard\Traits\DashboardGraphTrait;
use App\Http\Livewire\Components\Dashboard\Traits\DashboardModalsTrait;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class OverviewComponent extends Component
{
    use DashboardGraphTrait;
    use DashboardModalsTrait;

    /**
     * @var []
     */
    public $labels;

    /**
     * @var int
     */
    private $limit = 10;
    /**
     * @var CarbonPeriod
     */
    private $period = null;

    /**
     * @var string
     */
    public $colspan = 'w-1/3';
    /**
     * Describes which charts are open / closed
     * @var bool[]
     */
    public $open = [
        "prices" => true,
        "volumes" => true,
        "mix" => true,
    ];

    /**
     * Holds the limits on for the graphs
     */
    public $chartProperties;

    /**
     * Contains properties for the lines in the graphs
     * @var array[]
     */
    public $lineProperties = [
        "prices" => [
            "green" => [
                "data" => [],
                "label" => "Green",
                "borderColor" => "#4CD35B",
                "pointBackgroundColor" => "#4CD35B",
                "pointBorderColor" => "#4CD35B",
                "pointHoverBackgroundColor" => "#4CD35B",
                "pointHoverBorderColor" => "#4CD35B",
            ],
            "blue" => [
                "data" => [],
                "label" => "Blue",
                "borderColor" => "#0099FF",
                "pointBackgroundColor" => "#0099FF",
                "pointBorderColor" => "#0099FF",
                "pointHoverBackgroundColor" => "#0099FF",
                "pointHoverBorderColor" => "#0099FF",
            ],
            "grey" => [
                "data" => [],
                "label" => "Grey",
                "borderColor" => "#727272",
                "pointBackgroundColor" => "#727272",
                "pointBorderColor" => "#727272",
                "pointHoverBackgroundColor" => "#727272",
                "pointHoverBorderColor" => "#727272",

            ],
            "callback" => "getAveragePriceForDayAndH2TypeInCents",
        ],
        "volumes" => [
            "green" => [
                "data" => [],
                "label" => "Green",
                "borderColor" => "#4CD35B",
                "pointBackgroundColor" => "#4CD35B",
                "pointBorderColor" => "#4CD35B",
                "pointHoverBackgroundColor" => "#4CD35B",
                "pointHoverBorderColor" => "#4CD35B",
            ],
            "blue" => [
                "data" => [],
                "label" => "Blue",
                "borderColor" => "#0099FF",
                "pointBackgroundColor" => "#0099FF",
                "pointBorderColor" => "#0099FF",
                "pointHoverBackgroundColor" => "#0099FF",
                "pointHoverBorderColor" => "#0099FF",
            ],
            "grey" => [
                "data" => [],
                "label" => "Grey",
                "borderColor" => "#727272",
                "pointBackgroundColor" => "#727272",
                "pointBorderColor" => "#727272",
                "pointHoverBackgroundColor" => "#727272",
                "pointHoverBorderColor" => "#727272",
            ],
            "callback" => "getAllRunningTradesWithCalculatedEndDate",
        ],
        "mix" => [
            "grey" => [
                "data" => [],
                "label" => "Grey",
                "borderColor" => "#727272",
                "pointBackgroundColor" => "#727272",
                "pointBorderColor" => "#727272",
                "pointHoverBackgroundColor" => "#727272",
                "pointHoverBorderColor" => "#727272"
            ],
            "callback" => "getAverageAmountOfMixTradedForDay",
        ]
    ];

    protected $listeners = ['getDetailedDataForDay'];
    /**
     * @var bool|mixed
     */
    public $tooFewTrades;

    /**
     * Component constructor
     */
    public function mount()
    {
        if(!DetermineIfEnoughTradesToBaseAvarageAction::execute(5)){
            $this->tooFewTrades = true;
            $this->setDefaultLimits();
            return;
        }

        $this->determineColSpan();
        $this->setPeriod();
        $this->setLabels();
        //display price graph
        $this->displayGraphs();
    }

    private function setDefaultLimits()
    {
        foreach ($this->lineProperties as $lineProperty => $content){
            if($lineProperty != 'callback'){
                $this->chartProperties[$lineProperty]['limits']['min'] = 0;
                $this->chartProperties[$lineProperty]['limits']['max'] = 100;
            }
        }
    }

    /**
     * Execute all the actions that need to be performed to build the graphs
     */
    private function displayGraphs($type = null)
    {
        if($type !== null){
            $this->getDataForGraph($type, [$this, $this->lineProperties[$type]['callback']]);
        }else{
            foreach ($this->lineProperties as $typeOfGraph => $graphData) {
                $this->getDataForGraph($typeOfGraph, [$this, $graphData['callback']]);
            }
        }

        foreach ($this->lineProperties as $typeOfGraph => $graphData) {
            $this->setLimits($typeOfGraph);
        }
    }

    /**
     * Set a CarbonPeriod in the $period property
     */
    private function setPeriod()
    {
        $this->period = CarbonPeriod::create(Carbon::now()->subDays($this->limit - 1), Carbon::now());
    }

    /**
     * Fills the labels property with the formatted labels
     */
    private function setLabels()
    {
        foreach ($this->period as $day) {
            $this->labels[] = $day->format('M d Y');
        }
    }

    /**
     * Determine how wide a graph columns can be, based on active graphs
     */
    public function determineColSpan()
    {
        if (count(array_filter($this->open)) > 1) {
            $this->colspan = 'w-1/'.count(array_filter($this->open));
        } else {
            $this->colspan = 'w-full';
        }
    }

    /**
     * Render the component
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.components.dashboard.overview-component');
    }
}
