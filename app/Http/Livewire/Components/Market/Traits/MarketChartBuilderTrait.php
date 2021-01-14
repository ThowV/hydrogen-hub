<?php


namespace App\Http\Livewire\Components\Market\Traits;

use App\Http\Livewire\Components\Traits\ChartBuilderTrait;

trait MarketChartBuilderTrait
{
    use ChartBuilderTrait;

    public function calculateImpactValues($totalLoad, $impact, $bounds) {
        // Calculate the new load
        $loadRemoved = 0;
        $loadAdded = 0;
        $newTotalLoad = $totalLoad + $impact;

        if (($impact >= 0 && $totalLoad < 0) || ($impact < 0 && $totalLoad >= 0)) {
            if (($impact >= 0 && $newTotalLoad < 0) || $impact < 0 && $newTotalLoad >= 0) {
                $loadRemoved = -$impact; // We are removing all hydrogen
                $totalLoad = $newTotalLoad; // Our last total load is now what is left
            }
            else if (($impact >= 0 && $newTotalLoad >= 0) || ($impact < 0 && $newTotalLoad < 0)) {
                $loadRemoved = $totalLoad; // We are removing the entire last total load
                $totalLoad = 0; // Our last total load is now zero
                $loadAdded = $newTotalLoad; // We are adding what is left to be added
            }
        }
        else if ($impact >= 0) {
            $loadAdded = $impact; // We are adding all hydrogen
        }
        else if ($impact < 0) {
            $loadRemoved = $impact; // We are removing all hydrogen
        }

        // Update the min and max values
        foreach ([$totalLoad, $loadRemoved, $loadAdded, $newTotalLoad] as $value) {
            if ($value < $bounds[0]) {
                $bounds = $this->modifyBoundaries($value, $bounds[1]);
            }
            else if ($value > $bounds[1]) {
                $bounds = $this->modifyBoundaries($bounds[0], $value);
            }
        }

        return [
            "totalLoad" => $totalLoad,
            "newTotalLoad" => $newTotalLoad,
            "loadRemoved" => $loadRemoved,
            "loadAdded" => $loadAdded,
            "min" => $bounds[0],
            "max" => $bounds[1]
        ];
    }
}
