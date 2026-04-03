<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->state(['role' => 'client']),
            'specialist_id' => Specialist::factory(),
            'appointment_id' => Appointment::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional()->paragraph(),
        ];
    }
}
