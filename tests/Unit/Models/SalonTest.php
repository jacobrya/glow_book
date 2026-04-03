<?php

namespace Tests\Unit\Models;

use App\Models\Salon;
use App\Models\Specialist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalonTest extends TestCase
{
    use RefreshDatabase;

    public function test_average_rating_returns_average_of_specialists_ratings(): void
    {
        $salon = Salon::factory()->create();
        Specialist::factory()->create(['salon_id' => $salon->id, 'rating' => 4.50]);
        Specialist::factory()->create(['salon_id' => $salon->id, 'rating' => 3.50]);

        $this->assertEquals(4.0, $salon->averageRating());
    }

    public function test_average_rating_returns_zero_when_no_specialists(): void
    {
        $salon = Salon::factory()->create();

        $this->assertEquals(0, $salon->averageRating());
    }

    public function test_salon_has_owner_relationship(): void
    {
        $salon = Salon::factory()->create();

        $this->assertNotNull($salon->owner);
        $this->assertEquals('salon_owner', $salon->owner->role);
    }

    public function test_salon_has_many_specialists(): void
    {
        $salon = Salon::factory()->create();
        Specialist::factory()->count(3)->create(['salon_id' => $salon->id]);

        $this->assertCount(3, $salon->specialists);
    }

    public function test_salon_has_many_services(): void
    {
        $salon = Salon::factory()->create();
        \App\Models\Service::factory()->count(2)->create(['salon_id' => $salon->id]);

        $this->assertCount(2, $salon->services);
    }
}
