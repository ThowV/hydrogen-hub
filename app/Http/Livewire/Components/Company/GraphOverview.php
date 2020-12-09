<?php

namespace App\Http\Livewire\Components\Company;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class GraphOverview extends Component
{
    public function render()
    {
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
                if ($now->lessThanOrEqualTo($trade->endRaw)) {
                    $totalLoad += $trade->unitsToday;
                }
            }
            $totalLoads[] = $totalLoad;

            # Get max load
            $maxLoad = 0;
            if ($totalLoad > $maxLoad) {
                $maxLoad = $totalLoad + 0.15 * $totalLoad;
            }

        }

        return view('livewire.components.company.graph-overview')
            ->withLabels($dayLabels)->withMaxLoad($maxLoad)->withTotalLoad($totalLoads);
    }
}
