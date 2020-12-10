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

        foreach ($period as $day) {
            # Get date labels
            $dayLabels[] = $day->format('M d');

            # Get total loads
            $totalLoad = 0;
            foreach ($trades as $trade) {
                // Check if the trade is still running on this day
                if ($day->lessThanOrEqualTo($trade->endRaw)) {
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

            # Update the max and min load
            if ($totalLoad > $maxLoad) {
                $maxLoad = $totalLoad + ceil(0.15 * $totalLoad);
            }
            if ($totalLoad < $minLoad) {
                $minLoad = $totalLoad + floor(0.15 * $totalLoad);
            }
        }

        //dd($totalLoads);

        return view('livewire.components.company.graph-overview')
            ->withLabels($dayLabels)->withMaxLoad($maxLoad)->withMinLoad($minLoad)->withTotalLoad($totalLoads);
    }
}
