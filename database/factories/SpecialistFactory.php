<?php

namespace Database\Factories;

use App\Models\Salon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'specialist']),
            'salon_id' => Salon::factory(),
            'bio' => fake()->paragraph(),
            'experience_years' => fake()->numberBetween(0, 20),
            'rating' => 0,
        ];
    }
}
