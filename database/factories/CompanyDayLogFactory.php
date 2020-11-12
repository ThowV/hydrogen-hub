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
            'produced' => $this->faker->numberBetween(0, 1000000),
            'demand' => $this->faker->numberBetween(0, 1000000),
            'stored' => $this->faker->numberBetween(0, 1000000),
        ];
    }
}
