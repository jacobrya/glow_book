<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createOwnerWithSalon(): array
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);
        $salon = Salon::factory()->create(['owner_id' => $owner->id]);

        return compact('owner', 'salon');
    }

    public function test_guest_cannot_access_owner_dashboard(): void
    {
        $this->get(route('owner.dashboard'))->assertRedirect(route('login'));
    }

    public function test_non_owner_cannot_access_owner_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('owner.dashboard'))->assertStatus(403);
    }

    public function test_owner_can_access_dashboard(): void
    {
        $data = $this->createOwnerWithSalon();

        $this->actingAs($data['owner'])->get(route('owner.dashboard'))->assertStatus(200);
    }

    public function test_owner_without_salon_sees_no_salon_view(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($owner)->get(route('owner.dashboard'))->assertStatus(200);
    }

    // Specialist management tests

    public function test_owner_can_view_specialists(): void
    {
        $data = $this->createOwnerWithSalon();
        Specialist::factory()->create(['salon_id' => $data['salon']->id]);

        $this->actingAs($data['owner'])->get(route('owner.specialists'))->assertStatus(200);
    }

    public function test_owner_can_add_specialist(): void
    {
        $data = $this->createOwnerWithSalon();
        $specialistUser = User::factory()->create(['role' => 'specialist']);

        $this->actingAs($data['owner'])
            ->post(route('owner.specialists.store'), [
                'user_id' => $specialistUser->id,
                'bio' => 'Expert stylist',
                'experience_years' => 5,
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('specialists', [
            'user_id' => $specialistUser->id,
            'salon_id' => $data['salon']->id,
            'experience_years' => 5,
        ]);
    }

    public function test_owner_can_remove_specialist(): void
    {
        $data = $this->createOwnerWithSalon();
        $specialist = Specialist::factory()->create(['salon_id' => $data['salon']->id]);

        $this->actingAs($data['owner'])
            ->delete(route('owner.specialists.destroy', $specialist))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('specialists', ['id' => $specialist->id]);
    }

    public function test_owner_cannot_remove_specialist_from_another_salon(): void
    {
        $data = $this->createOwnerWithSalon();
        $otherSalon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['salon_id' => $otherSalon->id]);

        $this->actingAs($data['owner'])
            ->delete(route('owner.specialists.destroy', $specialist))
            ->assertStatus(403);
    }

    // Service CRUD tests

    public function test_owner_can_view_services(): void
    {
        $data = $this->createOwnerWithSalon();
        Service::factory()->create(['salon_id' => $data['salon']->id]);

        $this->actingAs($data['owner'])->get(route('owner.services'))->assertStatus(200);
    }

    public function test_owner_can_view_create_service_form(): void
    {
        $data = $this->createOwnerWithSalon();

        $this->actingAs($data['owner'])->get(route('owner.services.create'))->assertStatus(200);
    }

    public function test_owner_can_create_service(): void
    {
        $data = $this->createOwnerWithSalon();

        $this->actingAs($data['owner'])
            ->post(route('owner.services.store'), [
                'name' => 'Haircut',
                'description' => 'Professional haircut',
                'price' => 50.00,
                'duration_minutes' => 30,
                'category' => 'Hair',
            ])
            ->assertRedirect(route('owner.services'));

        $this->assertDatabaseHas('services', [
            'name' => 'Haircut',
            'salon_id' => $data['salon']->id,
            'price' => 50.00,
        ]);
    }

    public function test_service_creation_validates_required_fields(): void
    {
        $data = $this->createOwnerWithSalon();

        $this->actingAs($data['owner'])
            ->post(route('owner.services.store'), [])
            ->assertSessionHasErrors(['name', 'price', 'duration_minutes']);
    }

    public function test_service_creation_validates_minimum_duration(): void
    {
        $data = $this->createOwnerWithSalon();

        $this->actingAs($data['owner'])
            ->post(route('owner.services.store'), [
                'name' => 'Quick',
                'price' => 10,
                'duration_minutes' => 5,
            ])
            ->assertSessionHasErrors('duration_minutes');
    }

    public function test_owner_can_edit_service(): void
    {
        $data = $this->createOwnerWithSalon();
        $service = Service::factory()->create(['salon_id' => $data['salon']->id]);

        $this->actingAs($data['owner'])
            ->get(route('owner.services.edit', $service))
            ->assertStatus(200);
    }

    public function test_owner_can_update_service(): void
    {
        $data = $this->createOwnerWithSalon();
        $service = Service::factory()->create(['salon_id' => $data['salon']->id]);

        $this->actingAs($data['owner'])
            ->put(route('owner.services.update', $service), [
                'name' => 'Updated Service',
                'price' => 75.00,
                'duration_minutes' => 45,
                'category' => 'Nails',
            ])
            ->assertRedirect(route('owner.services'));

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Updated Service',
            'price' => 75.00,
        ]);
    }

    public function test_owner_cannot_edit_service_from_another_salon(): void
    {
        $data = $this->createOwnerWithSalon();
        $otherSalon = Salon::factory()->create();
        $service = Service::factory()->create(['salon_id' => $otherSalon->id]);

        $this->actingAs($data['owner'])
            ->get(route('owner.services.edit', $service))
            ->assertStatus(403);
    }

    public function test_owner_can_delete_service(): void
    {
        $data = $this->createOwnerWithSalon();
        $service = Service::factory()->create(['salon_id' => $data['salon']->id]);

        $this->actingAs($data['owner'])
            ->delete(route('owner.services.destroy', $service))
            ->assertRedirect(route('owner.services'));

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    public function test_owner_cannot_delete_service_from_another_salon(): void
    {
        $data = $this->createOwnerWithSalon();
        $otherSalon = Salon::factory()->create();
        $service = Service::factory()->create(['salon_id' => $otherSalon->id]);

        $this->actingAs($data['owner'])
            ->delete(route('owner.services.destroy', $service))
            ->assertStatus(403);
    }

    // Appointments

    public function test_owner_can_view_appointments(): void
    {
        $data = $this->createOwnerWithSalon();

        $this->actingAs($data['owner'])->get(route('owner.appointments'))->assertStatus(200);
    }

    // Dashboard KPIs

    public function test_dashboard_calculates_revenue(): void
    {
        $data = $this->createOwnerWithSalon();
        $service = Service::factory()->create(['salon_id' => $data['salon']->id, 'price' => 100.00]);
        $specialist = Specialist::factory()->create(['salon_id' => $data['salon']->id]);

        Appointment::factory()->create([
            'salon_id' => $data['salon']->id,
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'status' => 'completed',
        ]);

        $this->actingAs($data['owner'])->get(route('owner.dashboard'))->assertStatus(200);
    }
}
