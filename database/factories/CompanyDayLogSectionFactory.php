<?php

namespace Database\Factories;

use App\Models\CompanyDayLog;
use App\Models\CompanyDayLogSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyDayLogSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyDayLogSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $hydrogen_types = ['green', 'blue', 'grey', 'mix'];

        return [
            'company_day_log_id' => $this->faker->numberBetween(0, 10),
            'hydrogen_type' => $hydrogen_types[array_rand($hydrogen_types)],
            'produce' => $this->faker->numberBetween(0, 1000000),
            'demand' => $this->faker->numberBetween(0, 1000000),
            'store' => $this->faker->numberBetween(0, 1000000),
        ];
    }
}
