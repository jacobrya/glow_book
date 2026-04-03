<?php

namespace Database\Factories;

use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->state(['role' => 'client']),
            'specialist_id' => Specialist::factory(),
            'service_id' => Service::factory(),
            'salon_id' => Salon::factory(),
            'appointment_date' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'appointment_time' => fake()->randomElement(['09:00', '09:30', '10:00', '10:30', '11:00', '14:00', '15:00']),
            'status' => 'confirmed',
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed']);
    }

    public function cancelled(): static
    {
        return $this->state(['status' => 'cancelled']);
    }
}
