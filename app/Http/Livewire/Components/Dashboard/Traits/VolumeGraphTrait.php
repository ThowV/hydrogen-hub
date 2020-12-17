<?php


namespace App\Http\Livewire\Components\Dashboard\Traits;


trait VolumeGraphTrait
{
    /**
     * Get the ceiling of the graph
     */
    private function setLimitMax()
    {

    }
    /*
     * Get the floor of the graph
     */
    private function setLimitMin()
    {
    }

    private function getDataForGraph()
    {
        foreach ($this->period as $day) {
            foreach ($this->lineProperties['volumes'] as $key => $value) {
                $this->lineProperties['volumes'][$key]['data'][] = $this->getAveragePriceForDayAndH2TypeInCents($day, $key);
            }
        }
    }

    private function getAveragePriceForDayAndH2TypeInCents($day, $hydrogen_type, $depth = 0)
    {

    }
}
