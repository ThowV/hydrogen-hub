<?php

namespace App\Http\Livewire\Components\Company;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class GraphOverview extends Component
{
    public function render()
    {
        $maxLoad = $minLoad = 0;

        $now = Carbon::now();
        $periodEnd = $now->copy()->addDays(6);
        $period = CarbonPeriod::create($now->copy(), $periodEnd->copy());

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->trades->where('end_raw', '>=', $now->copy());

        // Get every demand between now and the next 7 days or longer
        $demandsColl = auth()->user()->company->dayLogs->where('date', '>=', $now->copy())->where('date', '<=', $periodEnd->copy());

        foreach ($period as $index=>$date) {
            # Get date labels
            $dayLabels[] = $date->format('M d');

            # Get total loads
            $totalLoad = 0;
            foreach ($trades as $trade) {
                // Check if the trade is still running on this date
                if ($date->lessThanOrEqualTo($trade->endRaw)) {
                    if ($trade->demander->id == auth()->user()->id) {
                        // We are receiving hydrogen
                        $totalLoad += $trade->unitsToday;
                    } else {
                        // We are sending hydrogen
                        $totalLoad -= $trade->unitsToday;
                    }
                }
            }
            $totalLoads[] = $totalLoad;

            # Get demands
            # Get first because faker generates multiple day logs with the same date, normally this isn't possible
            $dayLog = $demandsColl->where('date', '=', $date->toDateString())->first();

            if ($dayLog) {
                $demands[] = $dayLog->demand;
            }
            else {
                $demands[] = 0;
            }

            # Update the maximum
            if ($totalLoad > $maxLoad) {
                $maxLoad = $totalLoad + ceil(0.15 * $totalLoad);
            }
            if ($demands[$index] > $maxLoad) {
                $maxLoad = $demands[$index] + ceil(0.15 * $demands[$index]);
            }

            # Update the minimum
            if ($totalLoad < $minLoad) {
                $minLoad = $totalLoad + floor(0.15 * $totalLoad);
            }
            if ($demands[$index] < $minLoad) {
                $maxLoad = $demands[$index] + ceil(0.15 * $demands[$index]);
            }
        }

        return view('livewire.components.company.graph-overview')
            ->withLabels($dayLabels)->withMax($maxLoad)->withMin($minLoad)->withTotalLoads($totalLoads)->withDemands($demands);
    }
}
