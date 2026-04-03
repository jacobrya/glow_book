<?php

namespace Tests\Unit\Models;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialistTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_rating_calculates_average_from_reviews(): void
    {
        $salon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);
        $service = Service::factory()->create(['salon_id' => $salon->id]);

        foreach ([5, 4, 3] as $rating) {
            $client = User::factory()->create(['role' => 'client']);
            $appointment = Appointment::factory()->create([
                'client_id' => $client->id,
                'specialist_id' => $specialist->id,
                'service_id' => $service->id,
                'salon_id' => $salon->id,
                'status' => 'completed',
            ]);
            Review::factory()->create([
                'client_id' => $client->id,
                'specialist_id' => $specialist->id,
                'appointment_id' => $appointment->id,
                'rating' => $rating,
            ]);
        }

        $specialist->updateRating();

        $this->assertEquals(4.00, (float) $specialist->rating);
    }

    public function test_update_rating_sets_zero_when_no_reviews(): void
    {
        $specialist = Specialist::factory()->create();

        $specialist->updateRating();

        $this->assertEquals(0, (float) $specialist->rating);
    }

    public function test_specialist_belongs_to_user(): void
    {
        $user = User::factory()->create(['role' => 'specialist']);
        $specialist = Specialist::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $specialist->user->id);
    }

    public function test_specialist_belongs_to_salon(): void
    {
        $salon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);

        $this->assertEquals($salon->id, $specialist->salon->id);
    }

    public function test_specialist_has_many_to_many_services(): void
    {
        $salon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);
        $service = Service::factory()->create(['salon_id' => $salon->id]);

        $specialist->services()->attach($service->id);

        $this->assertCount(1, $specialist->services);
        $this->assertEquals($service->id, $specialist->services->first()->id);
    }
}
