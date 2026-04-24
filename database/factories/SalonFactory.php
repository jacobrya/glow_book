<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalonFactory extends Factory
{
    public function definition(): array
    {
        $salonNames = [
            'Glow Beauty Bar', 'Sulu Studio', 'Nail Room', 'Almaty Beauty', 
            'Silk Way Salon', 'Apple City Beauty', 'Tengri Spa', 'Lotus Studio', 
            'Elegance Salon', 'Aizhan Beauty', 'Aura Beauty Clinic', 'Zima Leto',
            'Brow Art', 'The Face Shop', 'Lounge Beauty'
        ];
        
        $streets = [
            'Abay Ave', 'Al-Farabi Ave', 'Tole Bi St', 'Gogol St', 
            'Dostyk Ave', 'Rozybakiev St', 'Seifullin Ave', 'Zheltoksan St',
            'Panfilov St', 'Baitursynov St', 'Timiryazev St', 'Samal-2 Microdistrict'
        ];

        $descriptions = [
            'The best beauty salon in the center of Almaty. We offer all kinds of hair services, manicures, and pedicures.',
            'Premium beauty studio. Individual approach to each client, cozy atmosphere, and professional masters.',
            'Modern beauty coworking and salon. We use only high-quality materials and follow the latest trends.',
            'Your perfect look is our job. Haircuts, complex coloring, styling, and makeup.',
            'An oasis of beauty and tranquility in a noisy city. Relaxing SPA treatments, facial and body care.',
        ];

        return [
            'name' => fake()->randomElement($salonNames),
            'description' => fake()->randomElement($descriptions),
            'address' => 'Almaty, ' . fake()->randomElement($streets) . ', ' . fake()->buildingNumber(),
            'phone' => '+7 (701) ' . fake()->numerify('### ## ##'),
            'image' => null,
            'owner_id' => User::factory()->state(['role' => 'salon_owner']),
        ];
    }
}
