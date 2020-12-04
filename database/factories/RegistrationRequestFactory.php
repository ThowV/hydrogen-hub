<?php

namespace Database\Factories;

use App\Models\RegistrationRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RegistrationRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "company_name" => $this->faker->company,
            "company_admin_email" => $this->faker->email,
            "company_admin_first_name"=> $this->faker->firstName,
            "company_admin_last_name"=> $this->faker->lastName,
            "status"=>rand(0,1),
        ];
    }
}
