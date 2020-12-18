<?php

namespace App\Http\Livewire\Components\Company;

use Livewire\Component;

class ChartExpandedModalComponent extends Component
{
    public $isOpen = false;
    public $chartType;

    protected $listeners = ['openChartExpandedModal' => 'toggleModal'];

    public function toggleModal($chartType = null)
    {
        $this->chartType = $chartType;
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.company.chart-expanded-modal-component');
    }
}
