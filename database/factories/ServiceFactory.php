<?php

namespace Database\Factories;

use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 200),
            'duration_minutes' => fake()->randomElement([30, 45, 60, 90, 120]),
            'category' => fake()->randomElement(['Hair', 'Nails', 'Makeup', 'Skin']),
            'salon_id' => Salon::factory(),
        ];
    }
}
