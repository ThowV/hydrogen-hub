<?php


namespace App\Models\ScopeTraits;


use App\Models\Trade;

trait CompanyActivityTrait
{
    /**
     * Gets the activities for a company as an array
     *
     * @return array
     */
    public function getAllActivities()
    {
        $activities = collect();
        $this->getAllSpecificActivities($activities, 'bought');
        $this->getAllSpecificActivities($activities, 'sold');

        return array_values($activities->sortByDesc(5)->toArray());
    }

    /**
     * Get the activities based on the specific action performed
     *
     * @param $array
     * @param $action
     * @return void
     */
    public function getAllSpecificActivities(&$array, $action)
    {
        $property = $action."Trades";
        foreach ($this->$property as $trade) {
            if (!$trade instanceof Trade) {
                continue;
            }
            $array[] = [
                $action,
                $trade->units_per_hour,
                $trade->end,
                $trade->hydrogen_type,
                ($trade->price_per_unit / 100),
                $trade->deal_made_at
            ];
        }
    }
}
