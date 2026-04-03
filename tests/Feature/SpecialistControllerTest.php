<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialistControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createSpecialistWithAppointment(): array
    {
        $user = User::factory()->create(['role' => 'specialist']);
        $salon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['user_id' => $user->id, 'salon_id' => $salon->id]);
        $service = Service::factory()->create(['salon_id' => $salon->id]);
        $client = User::factory()->create(['role' => 'client']);
        $appointment = Appointment::factory()->create([
            'client_id' => $client->id,
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'salon_id' => $salon->id,
            'appointment_date' => now()->format('Y-m-d'),
            'status' => 'confirmed',
        ]);

        return compact('user', 'salon', 'specialist', 'service', 'client', 'appointment');
    }

    public function test_guest_cannot_access_specialist_dashboard(): void
    {
        $this->get(route('specialist.dashboard'))->assertRedirect(route('login'));
    }

    public function test_non_specialist_cannot_access_specialist_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('specialist.dashboard'))->assertStatus(403);
    }

    public function test_specialist_can_access_dashboard(): void
    {
        $data = $this->createSpecialistWithAppointment();

        $this->actingAs($data['user'])->get(route('specialist.dashboard'))->assertStatus(200);
    }

    public function test_specialist_without_salon_sees_no_salon_view(): void
    {
        $user = User::factory()->create(['role' => 'specialist']);

        $this->actingAs($user)->get(route('specialist.dashboard'))->assertStatus(200);
    }

    public function test_specialist_can_mark_appointment_completed(): void
    {
        $data = $this->createSpecialistWithAppointment();

        $this->actingAs($data['user'])
            ->patch(route('specialist.appointments.status', $data['appointment']), [
                'status' => 'completed',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'id' => $data['appointment']->id,
            'status' => 'completed',
        ]);
    }

    public function test_specialist_can_cancel_appointment(): void
    {
        $data = $this->createSpecialistWithAppointment();

        $this->actingAs($data['user'])
            ->patch(route('specialist.appointments.status', $data['appointment']), [
                'status' => 'cancelled',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'id' => $data['appointment']->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_specialist_cannot_set_invalid_status(): void
    {
        $data = $this->createSpecialistWithAppointment();

        $this->actingAs($data['user'])
            ->patch(route('specialist.appointments.status', $data['appointment']), [
                'status' => 'pending',
            ])
            ->assertSessionHasErrors('status');
    }

    public function test_specialist_cannot_update_another_specialists_appointment(): void
    {
        $data = $this->createSpecialistWithAppointment();

        $otherUser = User::factory()->create(['role' => 'specialist']);
        Specialist::factory()->create(['user_id' => $otherUser->id, 'salon_id' => $data['salon']->id]);

        $this->actingAs($otherUser)
            ->patch(route('specialist.appointments.status', $data['appointment']), [
                'status' => 'completed',
            ])
            ->assertStatus(403);
    }
}
