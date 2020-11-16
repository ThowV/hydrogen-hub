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
        $enum = ['green', 'blue', 'grey'];
        $trades = ['offer', 'request'];
        $durationVal = $this->faker->numberBetween(1, 12);
        return [
            'owner_id' => 1,
            'responder_id' => 2,
            'trade_type' => $trades[array_rand($trades)],
            'hydrogen_type' => $enum[array_rand($enum)],
            'units_per_hour' => $this->faker->numberBetween(0, 1000),
            'duration' => $durationVal . ' ' . $this->faker->randomElement(['day', 'week', 'month']) . ($durationVal > 1 ? 's' : ''),
            'price_per_unit' => $this->faker->numberBetween(0, 1000),
            'mix_co2' => $this->faker->numberBetween(0, 100),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 years'),
        ];
    }
}
