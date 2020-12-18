<?php

namespace Database\Factories;

use App\Models\CompanyDayLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyDayLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyDayLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => rand(1,2),
            'date' => $this->faker->dateTimeBetween('now-1 days', '+9 days')
        ];
    }
}
