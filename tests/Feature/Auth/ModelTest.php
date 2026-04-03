<?php

namespace Tests\Feature;

use App\Models\Salon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArayModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_salon_has_correct_owner_id()
    {
        $user = User::factory()->create();

        $salon = Salon::create([
            'name' => 'Aray Beauty Studio',
            'address' => 'Almaty, Satpayev St',
            'description' => 'Best salon logic test',
            'owner_id' => $user->id,
        ]);

        $this->assertEquals($user->id, $salon->owner_id);
        $this->assertDatabaseHas('salons', ['name' => 'Aray Beauty Studio']);
    }
}
