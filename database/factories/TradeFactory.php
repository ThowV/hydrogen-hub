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
        $enum = ['green', 'blue', 'grey', 'mix'];
        $trades = ['offer', 'request'];
        $arr = [
            'owner_id' => rand(8, 25),
            'trade_type' => $trades[array_rand($trades)],
            'hydrogen_type' => $enum[array_rand($enum)],
            'units_per_hour' => $this->faker->numberBetween(0, 1000),
            'duration' => $this->faker->numberBetween(1, 168),
            'price_per_unit' => $this->faker->numberBetween(600, 800),
            'mix_co2' => $this->faker->numberBetween(0, 100),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 years'),
        ];

        return $arr;
    }
}
