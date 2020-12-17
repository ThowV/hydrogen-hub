<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Http\Livewire\Components\Dashboard\Traits\PriceGraphTrait;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class OverviewComponent extends Component
{

    use PriceGraphTrait;


    public $labels;
    private $limit = 50;
    private $period = null;
    public $colspan = 'w-1/3';
    public $open = [
        "prices" => true,
        "volumes" => true,
        "mixh2" => true,
    ];

    public $chartProperties = [
        'limits' => [
            'min' => 0,
            'max' => 1000
        ]
    ];

    public $lineProperties = [
        "prices" => [
            "green" => [
                "data" => [],
                "label" => "Green",
                "borderColor" => "#48AE60",
                "pointBackgroundColor" => "#fff",
                "pointBorderColor" => "#beffba",
                "pointHoverBackgroundColor" => "#d3ffb7",
                "pointHoverBorderColor" => "#b1ff53",
            ],
            "blue" => [
                "data" => [],
                "label" => "Blue",
                "borderColor" => "#1B42AE",
                "pointBackgroundColor" => "#fff",
                "pointBorderColor" => "#beffba",
                "pointHoverBackgroundColor" => "#d3ffb7",
                "pointHoverBorderColor" => "#b1ff53",
            ],
            "grey" => [
                "data" => [],
                "label" => "Grey",
                "borderColor" => "#676767",
                "pointBackgroundColor" => "#fff",
                "pointBorderColor" => "#beffba",
                "pointHoverBackgroundColor" => "#d3ffb7",
                "pointHoverBorderColor" => "#b1ff53",

            ],
            "callback" => "getAveragePriceForDayAndH2TypeInCents",
        ],
        "volumes" => [
            "callback" => "getAveragePriceForDayAndH2TypeInCents",

        ],
        "mix" => [
            "callback" => "getAveragePriceForDayAndH2TypeInCents",

        ]
    ];

    public function mount()
    {
        $this->determineColSpan();
        $this->setPeriod();
        $this->setLabels();
        //display price graph
        $this->displayPriceGraph();

    }

    private function displayPriceGraph()
    {
        foreach ($this->lineProperties as $typeOfGraph => $graphData) {
            $this->getDataForGraph($typeOfGraph, [$this, $graphData['callback']]);
            $this->setLimits($typeOfGraph);
        }
    }

    private function setPeriod()
    {
        $this->period = CarbonPeriod::create(Carbon::now()->subDays($this->limit - 1), Carbon::now());
    }

    private function setLabels()
    {
        foreach ($this->period as $day) {
            $this->labels[] = $day->format('M d');
        }
    }

    public function determineColSpan()
    {
        if (count(array_filter($this->open)) > 1) {
            $this->colspan = 'w-1/'.count(array_filter($this->open));
        } else {
            $this->colspan = 'w-full';
        }
    }

    public function render()
    {
        return view('livewire.components.dashboard.overview-component');
    }
}
