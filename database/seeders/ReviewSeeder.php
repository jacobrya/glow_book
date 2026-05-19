<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(array $appointments, array $clients, array $specialists): void
    {
        // ── Reviews ───────────────────────────────────────────────────────────
        Review::create(['client_id' => $clients[0]->id, 'specialist_id' => $specialists[1]->id,  'appointment_id' => $appointments[8]->id,  'rating' => 5, 'comment' => 'Dana is an amazing stylist! My hair looks absolutely perfect. Will definitely come back.']);
        Review::create(['client_id' => $clients[1]->id, 'specialist_id' => $specialists[2]->id,  'appointment_id' => $appointments[9]->id,  'rating' => 5, 'comment' => 'Kamila did incredible makeup for my event. Everyone was asking who did it!']);
        Review::create(['client_id' => $clients[2]->id, 'specialist_id' => $specialists[4]->id,  'appointment_id' => $appointments[10]->id, 'rating' => 5, 'comment' => 'Best keratin treatment ever! Aruzhan is so professional and the results lasted 4 months.']);
        Review::create(['client_id' => $clients[3]->id, 'specialist_id' => $specialists[5]->id,  'appointment_id' => $appointments[11]->id, 'rating' => 4, 'comment' => 'Lovely facial, my skin felt so refreshed. Tomiris explained every step. Very professional.']);
        Review::create(['client_id' => $clients[4]->id, 'specialist_id' => $specialists[8]->id,  'appointment_id' => $appointments[12]->id, 'rating' => 5, 'comment' => 'Gulnaz gives the best body massage in Shymkent. So relaxing, I fell asleep on the table!']);
        Review::create(['client_id' => $clients[5]->id, 'specialist_id' => $specialists[7]->id,  'appointment_id' => $appointments[13]->id, 'rating' => 4, 'comment' => 'Great hair straightening result. Asel was careful and thorough. Lasts really well.']);
        Review::create(['client_id' => $clients[6]->id, 'specialist_id' => $specialists[10]->id, 'appointment_id' => $appointments[14]->id, 'rating' => 5, 'comment' => 'Sandugash is a skincare genius. The anti-age facial made me look 5 years younger. Absolutely worth it!']);
        Review::create(['client_id' => $clients[7]->id, 'specialist_id' => $specialists[11]->id, 'appointment_id' => $appointments[15]->id, 'rating' => 5, 'comment' => 'Botakoz did perfect highlights. Natural, dimensional, exactly what I wanted. Very happy!']);
        Review::create(['client_id' => $clients[0]->id, 'specialist_id' => $specialists[5]->id,  'appointment_id' => $appointments[16]->id, 'rating' => 4, 'comment' => 'Beautiful lash extensions, very natural looking. Tomiris was precise and quick.']);
        Review::create(['client_id' => $clients[3]->id, 'specialist_id' => $specialists[0]->id,  'appointment_id' => $appointments[17]->id, 'rating' => 5, 'comment' => 'Aigerim is truly a nail artist. My pedicure was perfect. Super clean and relaxing experience.']);
    }
}
