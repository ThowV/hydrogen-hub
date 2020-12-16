<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Http\Livewire\Components\Dashboard\Traits\PriceGraphTrait;
use Livewire\Component;

class OverviewComponent extends Component
{

    use PriceGraphTrait;

    public $priceGraphLabels;
    private $limit = 10;
    private $period = null;
    public $colspan = 'w-1/3';
    public $open = [
      "prices"  => true,
      "volumes"  => true,
      "mixh2"  => true,
    ];

    public $chartProperties = [
        'limits' => [
            'min' => 0,
            'max' => 1000
        ]
    ];

    public $lineProperties = [
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
        ]
    ];

    public function mount()
    {
        $this->setPeriod();
        //display price graph
        $this->displayPriceGraph();
    }

    private function displayPriceGraph()
    {
        $this->determineColSpan();
        $this->getDataForGraph();
        $this->setLabels();
        $this->setLimitMax();
        $this->setLimitMin();
    }

    public function determineColSpan(){
        if(count(array_filter($this->open)) > 1){
            $this->colspan = 'w-1/'.count(array_filter($this->open));
        }else{
            $this->colspan = 'w-full';
        }
    }

    public function render()
    {
        return view('livewire.components.dashboard.overview-component');
    }
}
