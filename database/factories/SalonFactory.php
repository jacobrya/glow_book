<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'image' => null,
            'owner_id' => User::factory()->state(['role' => 'salon_owner']),
        ];
    }
}
