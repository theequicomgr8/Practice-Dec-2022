<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
	 protected $model = Student::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('123'),
			'mobile' => $this->faker->phoneNumber(),
        ];
    }
}

