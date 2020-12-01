<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
public function definition()
    {
        return [
            'name' => $this->faker->company,
            'owner_id' => User::whereDoesntHave('isOwnerOf')->first()->id == 1 ? rand(1,10): 1,
            'usable_fund' => $this->faker->numberBetween(0, 9000000)
        ];
    }
}
