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
            "borderColor" => "#63ff00",
            "pointBackgroundColor" => "#fff",
            "pointBorderColor" => "#beffba",
            "pointHoverBackgroundColor" => "#d3ffb7",
            "pointHoverBorderColor" => "#b1ff53",
        ],
        "blue" => [
            "data" => [],
            "label" => "Blue",
            "borderColor" => "#3300AA",
            "pointBackgroundColor" => "#fff",
            "pointBorderColor" => "#beffba",
            "pointHoverBackgroundColor" => "#d3ffb7",
            "pointHoverBorderColor" => "#b1ff53",
        ],
        "grey" => [
            "data" => [],
            "label" => "Grey",
            "borderColor" => "#AA3300",
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
        $this->getDataForGraph();
        $this->setLabels();
        $this->setLimitMax();
        $this->setLimitMin();
    }

    public function render()
    {
        return view('livewire.components.dashboard.overview-component');
    }
}
