<?php

namespace App\Http\Livewire\Components\Company;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class GraphOverview extends Component
{
    public function render()
    {
        $minLoad = 0;
        $maxLoad = 100;

        $shortage = null;

        $now = Carbon::now();
        $periodEnd = $now->copy()->addDays(6);
        $period = CarbonPeriod::create($now->copy(), $periodEnd->copy());

        // Get every trade that is active between now and the next 7 days or longer
        $trades = auth()->user()->company->trades->where('end_raw', '>=', $now->copy());

        // Get every demand between now and the next 7 days or longer
        $dayLogs = auth()->user()->company->dayLogs->where('date', '>=', $now->copy())->where('date', '<=', $periodEnd->copy());

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
            $boundaries[] = $totalLoad;

            # Get demands
            # Get first because faker generates multiple day logs with the same date, normally this isn't possible
            $dayLog = $dayLogs->where('date', '=', $date->toDateString())->first();

            if ($dayLog && !$dayLog->sections->isEmpty()) {
                # Get first because we don't have type splitting yet
                $section = $dayLog->sections()->first();
                $demands[] = $section->demand;
                $boundaries[] = $section->demand;
            }
            else {
                $demands[] = 0;
            }

            # Update the minimum and maximum
            foreach ($boundaries as $boundary) {
                if ($boundary > $maxLoad) {
                    $maxLoad = $boundary + ceil(0.15 * $boundary);
                }
                if ($boundary < $minLoad) {
                    $minLoad = $boundary + ceil(0.15 * $boundary);
                }
            }

            # Get the shortage if it wasn't already present
            if (!$shortage && $totalLoad < $demands[$index]) {
                $shortage = $date->format('M d') . ' - ' . ($demands[$index] - $totalLoad) . ' units short';
            }
        }

        return view('livewire.components.company.graph-overview')
            ->withLabels($dayLabels)->withMax($maxLoad)->withMin($minLoad)->withTotalLoads($totalLoads)
            ->withDemands($demands)->withShortage($shortage);
    }
}
