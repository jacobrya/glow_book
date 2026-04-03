<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    // Admin middleware

    public function test_admin_middleware_allows_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertStatus(200);
    }

    public function test_admin_middleware_blocks_client(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('admin.dashboard'))->assertStatus(403);
    }

    public function test_admin_middleware_blocks_guest(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    // Owner middleware

    public function test_owner_middleware_allows_salon_owner(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($owner)->get(route('owner.dashboard'))->assertStatus(200);
    }

    public function test_owner_middleware_blocks_client(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('owner.dashboard'))->assertStatus(403);
    }

    public function test_owner_middleware_blocks_specialist(): void
    {
        $specialist = User::factory()->create(['role' => 'specialist']);

        $this->actingAs($specialist)->get(route('owner.dashboard'))->assertStatus(403);
    }

    // Specialist middleware

    public function test_specialist_middleware_allows_specialist(): void
    {
        $user = User::factory()->create(['role' => 'specialist']);

        $this->actingAs($user)->get(route('specialist.dashboard'))->assertStatus(200);
    }

    public function test_specialist_middleware_blocks_client(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('specialist.dashboard'))->assertStatus(403);
    }

    public function test_specialist_middleware_blocks_owner(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($owner)->get(route('specialist.dashboard'))->assertStatus(403);
    }

    // Dashboard redirect

    public function test_dashboard_redirects_admin_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
    }

    public function test_dashboard_redirects_owner_to_owner_dashboard(): void
    {
        $owner = User::factory()->create(['role' => 'salon_owner']);

        $this->actingAs($owner)->get(route('dashboard'))->assertRedirect(route('owner.dashboard'));
    }

    public function test_dashboard_redirects_specialist_to_specialist_dashboard(): void
    {
        $specialist = User::factory()->create(['role' => 'specialist']);

        $this->actingAs($specialist)->get(route('dashboard'))->assertRedirect(route('specialist.dashboard'));
    }

    public function test_dashboard_redirects_client_to_client_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('dashboard'))->assertRedirect(route('client.dashboard'));
    }
}
