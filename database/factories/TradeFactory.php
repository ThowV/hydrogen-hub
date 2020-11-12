<?php

namespace Database\Factories;

use App\Models\Trade;
use Illuminate\Database\Eloquent\Factories\Factory;

class TradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trade_type' => array_rand(['offer', 'request']),
            'hydrogen_type' => array_rand(['green', 'blue', 'grey']),
            'units_per_hour' => $this->faker->numberBetween(0, 1000),
            'volumes' => $this->faker->numberBetween(0, 1000000),
            'price_per_unit' => $this->faker->numberBetween(0, 1000),
            'mix_co2' => $this->faker->numberBetween(0, 100),
            'ends_at' => $this->faker->dateTimeBetween('now', '+1 years'),
        ];
    }
}
