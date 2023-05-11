<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // "id" => $this->faker->unique()->numberBetween(10,100_000),
            'first_name' => $this->faker->unique()->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone_number' => $this->faker->unique()->e164PhoneNumber(),
            'password' => Hash::make('password'), // password
        ];
    }
    // public function configure()
    // {
    //     return $this->afterCreating(function (User $user){
    //         if($user->type == 'طالب'){
    //             Student::factory()
    //         }
    //     });
    // }
}
