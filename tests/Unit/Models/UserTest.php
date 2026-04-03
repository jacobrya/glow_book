<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_returns_true_for_admin_role(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isSalonOwner());
        $this->assertFalse($user->isSpecialist());
        $this->assertFalse($user->isClient());
    }

    public function test_is_salon_owner_returns_true_for_salon_owner_role(): void
    {
        $user = User::factory()->create(['role' => 'salon_owner']);

        $this->assertTrue($user->isSalonOwner());
        $this->assertFalse($user->isAdmin());
    }

    public function test_is_specialist_returns_true_for_specialist_role(): void
    {
        $user = User::factory()->create(['role' => 'specialist']);

        $this->assertTrue($user->isSpecialist());
        $this->assertFalse($user->isClient());
    }

    public function test_is_client_returns_true_for_client_role(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $this->assertTrue($user->isClient());
        $this->assertFalse($user->isAdmin());
    }

    public function test_user_has_specialist_relationship(): void
    {
        $user = User::factory()->create(['role' => 'specialist']);
        $specialist = \App\Models\Specialist::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($user->specialist);
        $this->assertEquals($specialist->id, $user->specialist->id);
    }

    public function test_user_has_owned_salons_relationship(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);
        $salon = \App\Models\Salon::factory()->create(['owner_id' => $owner->id]);

        $this->assertCount(1, $owner->ownedSalons);
        $this->assertEquals($salon->id, $owner->ownedSalons->first()->id);
    }

    public function test_user_has_client_appointments_relationship(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $salon = \App\Models\Salon::factory()->create();
        $service = \App\Models\Service::factory()->create(['salon_id' => $salon->id]);
        $specialist = \App\Models\Specialist::factory()->create(['salon_id' => $salon->id]);

        \App\Models\Appointment::factory()->create([
            'client_id' => $client->id,
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'salon_id' => $salon->id,
        ]);

        $this->assertCount(1, $client->clientAppointments);
    }

    public function test_user_has_reviews_relationship(): void
    {
        $client = User::factory()->create(['role' => 'client']);
        $salon = \App\Models\Salon::factory()->create();
        $specialist = \App\Models\Specialist::factory()->create(['salon_id' => $salon->id]);
        $service = \App\Models\Service::factory()->create(['salon_id' => $salon->id]);
        $appointment = \App\Models\Appointment::factory()->create([
            'client_id' => $client->id,
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'salon_id' => $salon->id,
            'status' => 'completed',
        ]);

        \App\Models\Review::factory()->create([
            'client_id' => $client->id,
            'specialist_id' => $specialist->id,
            'appointment_id' => $appointment->id,
        ]);

        $this->assertCount(1, $client->reviews);
    }
}
