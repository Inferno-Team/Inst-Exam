<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'univ_id' => $this->faker->unique()->numberBetween(1_000, 10_000),

            'father_name' => $this->faker->firstNameMale(),
            'mother_name' => $this->faker->firstNameFemale(),
            'birth_place' => $this->faker->address(),
            'gender' => $this->sequence(['ذكر', 'انثى']),
            'field_number' => $this->faker->numberBetween(1, 30),
            'recruitment_division' => NULL,
            'city' => 'حلب',
            'address' => 'حلب',
            'nationalty' => 'ع.س'
        ];
    }
}
