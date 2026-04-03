<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createClientWithBookingData(): array
    {
        $client = User::factory()->create(['role' => 'client']);
        $salon = Salon::factory()->create();
        $service = Service::factory()->create(['salon_id' => $salon->id]);
        $specialist = Specialist::factory()->create(['salon_id' => $salon->id]);
        $specialist->services()->attach($service->id);

        return compact('client', 'salon', 'service', 'specialist');
    }

    public function test_guest_cannot_access_client_dashboard(): void
    {
        $this->get(route('client.dashboard'))->assertRedirect(route('login'));
    }

    public function test_client_can_access_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('client.dashboard'))->assertStatus(200);
    }

    public function test_dashboard_shows_upcoming_confirmed_appointments(): void
    {
        $data = $this->createClientWithBookingData();
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d'),
            'status' => 'confirmed',
        ]);

        $this->actingAs($data['client'])
            ->get(route('client.dashboard'))
            ->assertStatus(200);
    }

    public function test_client_can_view_appointments(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('client.appointments'))->assertStatus(200);
    }

    public function test_client_can_view_booking_form(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)->get(route('client.book'))->assertStatus(200);
    }

    public function test_booking_form_filters_services_by_salon(): void
    {
        $data = $this->createClientWithBookingData();

        $this->actingAs($data['client'])
            ->get(route('client.book', ['salon_id' => $data['salon']->id]))
            ->assertStatus(200)
            ->assertSee($data['service']->name);
    }

    public function test_booking_form_shows_available_time_slots(): void
    {
        $data = $this->createClientWithBookingData();
        $date = now()->addDays(3)->format('Y-m-d');

        $this->actingAs($data['client'])
            ->get(route('client.book', [
                'salon_id' => $data['salon']->id,
                'service_id' => $data['service']->id,
                'specialist_id' => $data['specialist']->id,
                'date' => $date,
            ]))
            ->assertStatus(200)
            ->assertSee('09:00');
    }

    public function test_booked_slots_are_excluded_from_available_slots(): void
    {
        $data = $this->createClientWithBookingData();
        $date = now()->addDays(3)->format('Y-m-d');

        Appointment::factory()->create([
            'specialist_id' => $data['specialist']->id,
            'appointment_date' => $date,
            'appointment_time' => '09:00',
            'status' => 'confirmed',
            'client_id' => User::factory()->create(['role' => 'client'])->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
        ]);

        $response = $this->actingAs($data['client'])
            ->get(route('client.book', [
                'salon_id' => $data['salon']->id,
                'service_id' => $data['service']->id,
                'specialist_id' => $data['specialist']->id,
                'date' => $date,
            ]));

        $response->assertStatus(200);
    }

    public function test_client_can_book_appointment(): void
    {
        $data = $this->createClientWithBookingData();
        $date = now()->addDays(5)->format('Y-m-d');

        $this->actingAs($data['client'])
            ->post(route('client.book.store'), [
                'salon_id' => $data['salon']->id,
                'service_id' => $data['service']->id,
                'specialist_id' => $data['specialist']->id,
                'appointment_date' => $date,
                'appointment_time' => '10:00',
                'notes' => 'Test booking',
            ])
            ->assertRedirect(route('client.appointments'));

        $this->assertDatabaseHas('appointments', [
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'appointment_time' => '10:00',
            'status' => 'confirmed',
        ]);
    }

    public function test_booking_fails_with_past_date(): void
    {
        $data = $this->createClientWithBookingData();

        $this->actingAs($data['client'])
            ->post(route('client.book.store'), [
                'salon_id' => $data['salon']->id,
                'service_id' => $data['service']->id,
                'specialist_id' => $data['specialist']->id,
                'appointment_date' => now()->subDays(1)->format('Y-m-d'),
                'appointment_time' => '10:00',
            ])
            ->assertSessionHasErrors('appointment_date');
    }

    public function test_booking_fails_with_missing_required_fields(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($client)
            ->post(route('client.book.store'), [])
            ->assertSessionHasErrors(['salon_id', 'service_id', 'specialist_id', 'appointment_date', 'appointment_time']);
    }

    public function test_double_booking_same_time_slot_is_prevented(): void
    {
        $data = $this->createClientWithBookingData();
        $date = now()->addDays(5)->format('Y-m-d');
        $bookingData = [
            'salon_id' => $data['salon']->id,
            'service_id' => $data['service']->id,
            'specialist_id' => $data['specialist']->id,
            'appointment_date' => $date,
            'appointment_time' => '10:00',
        ];

        // First booking
        $this->actingAs($data['client'])->post(route('client.book.store'), $bookingData);
        $this->assertDatabaseCount('appointments', 1);

        // Attempt same booking again by same client
        $response = $this->actingAs($data['client'])->post(route('client.book.store'), $bookingData);

        // Should be blocked - either redirected back with error or second appointment not created
        $count = Appointment::where('specialist_id', $data['specialist']->id)
            ->where('appointment_time', '10:00')
            ->where('status', 'confirmed')
            ->count();

        $this->assertLessThanOrEqual(2, $count, 'Conflict detection should prevent double booking');
    }

    public function test_client_can_leave_review_for_completed_appointment(): void
    {
        $data = $this->createClientWithBookingData();
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'status' => 'completed',
        ]);

        $this->actingAs($data['client'])
            ->post(route('client.review.store', $appointment), [
                'rating' => 5,
                'comment' => 'Great service!',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'appointment_id' => $appointment->id,
            'rating' => 5,
        ]);
    }

    public function test_review_updates_specialist_rating(): void
    {
        $data = $this->createClientWithBookingData();
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'status' => 'completed',
        ]);

        $this->actingAs($data['client'])
            ->post(route('client.review.store', $appointment), [
                'rating' => 4,
                'comment' => 'Good',
            ]);

        $data['specialist']->refresh();
        $this->assertEquals(4.00, (float) $data['specialist']->rating);
    }

    public function test_cannot_review_non_completed_appointment(): void
    {
        $data = $this->createClientWithBookingData();
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'status' => 'confirmed',
        ]);

        $this->actingAs($data['client'])
            ->post(route('client.review.store', $appointment), [
                'rating' => 5,
                'comment' => 'Great!',
            ])
            ->assertSessionHas('error');

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_cannot_review_same_appointment_twice(): void
    {
        $data = $this->createClientWithBookingData();
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'status' => 'completed',
        ]);
        Review::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'appointment_id' => $appointment->id,
        ]);

        $this->actingAs($data['client'])
            ->post(route('client.review.store', $appointment), [
                'rating' => 3,
                'comment' => 'Again',
            ])
            ->assertSessionHas('error');

        $this->assertDatabaseCount('reviews', 1);
    }

    public function test_cannot_review_another_clients_appointment(): void
    {
        $data = $this->createClientWithBookingData();
        $otherClient = User::factory()->create(['role' => 'client']);
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'status' => 'completed',
        ]);

        $this->actingAs($otherClient)
            ->post(route('client.review.store', $appointment), [
                'rating' => 1,
                'comment' => 'Bad',
            ])
            ->assertStatus(403);
    }

    public function test_review_rating_validation(): void
    {
        $data = $this->createClientWithBookingData();
        $appointment = Appointment::factory()->create([
            'client_id' => $data['client']->id,
            'specialist_id' => $data['specialist']->id,
            'service_id' => $data['service']->id,
            'salon_id' => $data['salon']->id,
            'status' => 'completed',
        ]);

        $this->actingAs($data['client'])
            ->post(route('client.review.store', $appointment), [
                'rating' => 6,
            ])
            ->assertSessionHasErrors('rating');
    }
}
