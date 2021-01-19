<?php


namespace App\Http\Livewire\Components\Dashboard\Traits;

use Carbon\Carbon;

trait DashboardModalsTrait
{

    public $modalIsOpen = false;
    public $typeOfGraphInModal;
    public $selectedTimeRange = '50';
    public $timeRanges = [
        "1" => '1 day',
        "7" => '1 week',
        "183" => '6 months'
    ];

    public function getDetailedDataForDay($index)
    {
        dd(new Carbon($this->labels[$index]));
    }

    public function toggleModal()
    {
        $this->modalIsOpen = !$this->modalIsOpen;
    }

    public function getDetailedModalData()
    {
        return $this->getDataForGraph($this->typeOfGraphInModal, [$this, $this->lineProperties[$this->typeOfGraphInModal]['callback']]);
    }

    public function openDetailedGraphModal($typeOfGraphInModal)
    {
        $this->reset();
        $this->typeOfGraphInModal = $typeOfGraphInModal;
        $this->limit = $this->selectedTimeRange;
        $this->setPeriod();
        $this->setLabels();
        $this->displayGraphs($typeOfGraphInModal);
        $this->toggleModal();
        $this->render();
    }

    public function updated()
    {
        $this->openDetailedGraphModal($this->typeOfGraphInModal);
    }

}
