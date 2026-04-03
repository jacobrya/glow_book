<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        $appointment = Appointment::where('status', 'completed')->inRandomOrder()->first();

        return [
            'client_id' => $appointment->client_id,
            'specialist_id' => $appointment->specialist_id,
            'appointment_id' => $appointment->id,
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}