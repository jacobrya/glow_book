<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        $specialist = Specialist::has('services')->inRandomOrder()->first(); // только с услугами
    $service = $specialist->services()->inRandomOrder()->first();
    $statuses = ['confirmed', 'completed', 'cancelled'];

        return [
            'client_id' => \App\Models\User::where('role', 'client')->inRandomOrder()->first()->id,
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'salon_id' => $specialist->salon_id,
            'appointment_date' => $this->faker->dateTimeBetween('-30 days', '+30 days'),
            'appointment_time' => $this->faker->time('H:i'),
            'status' => $this->faker->randomElement($statuses),
            'notes' => $this->faker->sentence(),
        ];
    }
}