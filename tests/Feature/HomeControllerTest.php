<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $this->get(route('home'))->assertStatus(200);
    }

    public function test_home_page_displays_salons(): void
    {
        $salon = Salon::factory()->create(['name' => 'Test Salon']);

        $this->get(route('home'))->assertStatus(200)->assertSee('Test Salon');
    }

    public function test_salons_page_loads_successfully(): void
    {
        Salon::factory()->count(3)->create();

        $this->get(route('salons'))->assertStatus(200);
    }

    public function test_salon_detail_page_loads_successfully(): void
    {
        $salon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);

        $this->get(route('salons.show', $salon))->assertStatus(200)->assertSee($salon->name);
    }

    public function test_salon_detail_shows_reviews(): void
    {
        $salon = Salon::factory()->create();
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);
        $service = Service::factory()->create(['salon_id' => $salon->id]);
        $client = User::factory()->create(['role' => 'client']);
        $appointment = \App\Models\Appointment::factory()->create([
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
            'rating' => 5,
            'comment' => 'Excellent service!',
        ]);

        $this->get(route('salons.show', $salon))->assertStatus(200)->assertSee('Excellent service!');
    }

    public function test_services_page_loads_successfully(): void
    {
        Service::factory()->count(2)->create();

        $this->get(route('services'))->assertStatus(200);
    }

    public function test_specialists_page_loads_successfully(): void
    {
        Specialist::factory()->count(2)->create();

        $this->get(route('specialists'))->assertStatus(200);
    }
}
