<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('admin.dashboard'))->assertStatus(403);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $this->actingAs($this->createAdmin())->get(route('admin.dashboard'))->assertStatus(200);
    }

    public function test_admin_can_view_users(): void
    {
        User::factory()->count(3)->create();

        $this->actingAs($this->createAdmin())->get(route('admin.users'))->assertStatus(200);
    }

    // Appointments

    public function test_admin_can_view_all_appointments(): void
    {
        $this->actingAs($this->createAdmin())->get(route('admin.appointments'))->assertStatus(200);
    }

    public function test_admin_can_filter_appointments_by_status(): void
    {
        $salon = Salon::factory()->create();
        $service = Service::factory()->create(['salon_id' => $salon->id]);
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);

        Appointment::factory()->create([
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'salon_id' => $salon->id,
            'status' => 'completed',
        ]);
        Appointment::factory()->create([
            'specialist_id' => $specialist->id,
            'service_id' => $service->id,
            'salon_id' => $salon->id,
            'status' => 'confirmed',
        ]);

        $this->actingAs($this->createAdmin())
            ->get(route('admin.appointments', ['status' => 'completed']))
            ->assertStatus(200);
    }

    // Salon CRUD

    public function test_admin_can_view_salons(): void
    {
        Salon::factory()->count(2)->create();

        $this->actingAs($this->createAdmin())->get(route('admin.salons'))->assertStatus(200);
    }

    public function test_admin_can_view_create_salon_form(): void
    {
        $this->actingAs($this->createAdmin())->get(route('admin.salons.create'))->assertStatus(200);
    }

    public function test_admin_can_create_salon(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($this->createAdmin())
            ->post(route('admin.salons.store'), [
                'name' => 'New Salon',
                'description' => 'A great salon',
                'address' => '123 Main St',
                'phone' => '555-1234',
                'owner_id' => $owner->id,
            ])
            ->assertRedirect(route('admin.salons'));

        $this->assertDatabaseHas('salons', [
            'name' => 'New Salon',
            'owner_id' => $owner->id,
        ]);
    }

    public function test_salon_creation_validates_required_fields(): void
    {
        $this->actingAs($this->createAdmin())
            ->post(route('admin.salons.store'), [])
            ->assertSessionHasErrors(['name', 'address', 'owner_id']);
    }

    public function test_admin_can_edit_salon(): void
    {
        $salon = Salon::factory()->create();

        $this->actingAs($this->createAdmin())
            ->get(route('admin.salons.edit', $salon))
            ->assertStatus(200);
    }

    public function test_admin_can_update_salon(): void
    {
        $salon = Salon::factory()->create();
        $newOwner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($this->createAdmin())
            ->put(route('admin.salons.update', $salon), [
                'name' => 'Updated Salon',
                'address' => '456 New Ave',
                'owner_id' => $newOwner->id,
            ])
            ->assertRedirect(route('admin.salons'));

        $this->assertDatabaseHas('salons', [
            'id' => $salon->id,
            'name' => 'Updated Salon',
            'owner_id' => $newOwner->id,
        ]);
    }

    public function test_admin_can_delete_salon(): void
    {
        $salon = Salon::factory()->create();

        $this->actingAs($this->createAdmin())
            ->delete(route('admin.salons.destroy', $salon))
            ->assertRedirect(route('admin.salons'));

        $this->assertDatabaseMissing('salons', ['id' => $salon->id]);
    }

    // Role-based access

    public function test_specialist_cannot_access_admin_routes(): void
    {
        $specialist = User::factory()->create(['role' => 'specialist']);

        $this->actingAs($specialist)->get(route('admin.dashboard'))->assertStatus(403);
        $this->actingAs($specialist)->get(route('admin.users'))->assertStatus(403);
        $this->actingAs($specialist)->get(route('admin.salons'))->assertStatus(403);
    }

    public function test_salon_owner_cannot_access_admin_routes(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($owner)->get(route('admin.dashboard'))->assertStatus(403);
        $this->actingAs($owner)->get(route('admin.users'))->assertStatus(403);
    }
}
