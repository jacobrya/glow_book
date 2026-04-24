<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalonFactory extends Factory
{
    public function definition(): array
    {
        $salonNames = [
            'Glow Beauty Bar', 'Sulu Studio', 'Nail Room', 'Silk Way Salon',
            'Tengri Spa', 'Lotus Studio', 'Elegance Salon', 'Aizhan Beauty',
            'Aura Beauty Clinic', 'Brow Art', 'Lounge Beauty', 'Altyn Studio',
            'Nur Beauty', 'Steppe Glow', 'Dala Spa',
        ];

        $cities = [
            'Almaty', 'Astana', 'Shymkent', 'Karaganda',
            'Aktobe', 'Atyrau', 'Pavlodar', 'Semey',
        ];

        $streetsByCity = [
            'Almaty'    => ['Abay Ave', 'Al-Farabi Ave', 'Dostyk Ave', 'Tole Bi St', 'Rozybakiev St', 'Seifullin Ave', 'Zheltoksan St'],
            'Astana'    => ['Mangilik El Ave', 'Kabanbay Batyr Ave', 'Kerey & Zhanibek Khans St', 'Beibitshilik St', 'Turan Ave'],
            'Shymkent'  => ['Tauke Khan Ave', 'Dulati St', 'Karatay St', 'Al-Farabi Ave', 'Bayzakov St'],
            'Karaganda' => ['Bukharzyrau Ave', 'Nurken Abishev St', 'Erubaev St', 'Gogol St', 'Abdirova Ave'],
            'Aktobe'    => ['Abilkhayr Khan Ave', 'Bratiev Zhubanovy St', 'Moldagulova Ave'],
            'Atyrau'    => ['Azattyk Ave', 'Baimukhanov St', 'Sultan Beibarys St'],
            'Pavlodar'  => ['Lenina St', 'Kachevaya St', 'Satpayev St'],
            'Semey'     => ['Shakarim Ave', 'Internatsionalnaya St', 'Abaya St'],
        ];

        $descriptions = [
            'Premium beauty studio offering top-tier services with experienced professionals in a modern setting.',
            'Your go-to destination for nails, hair, and makeup with the latest techniques and products.',
            'A cozy and professional salon. Full range of beauty services delivered by certified masters.',
            'Luxury spa and beauty center. Relax and rejuvenate with our wide selection of services.',
            'Modern beauty studio with an individual approach to each client and a cozy atmosphere.',
        ];

        $city = fake()->randomElement($cities);
        $streets = $streetsByCity[$city];

        return [
            'name'        => fake()->randomElement($salonNames),
            'description' => fake()->randomElement($descriptions),
            'city'        => $city,
            'address'     => fake()->randomElement($streets) . ' ' . fake()->buildingNumber() . ', ' . $city,
            'phone'       => '+7 (' . fake()->randomElement(['701', '702', '705', '707', '771', '775']) . ') ' . fake()->numerify('### ## ##'),
            'image'       => null,
            'owner_id'    => User::factory()->state(['role' => 'salon_owner']),
        ];
    }
}
