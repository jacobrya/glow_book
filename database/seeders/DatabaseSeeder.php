<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admins ────────────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Aslan Nurlanov',
            'email'    => 'admin@glowbook.kz',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '+7 701 111 1111',
        ]);

        // ── Salon owners ──────────────────────────────────────────────────────
        $owner1 = User::create([
            'name'     => 'Dinara Abdrakhmanova',
            'email'    => 'owner@glowbook.kz',
            'password' => Hash::make('password'),
            'role'     => 'salon_owner',
            'phone'    => '+7 701 222 2222',
        ]);

        $owner2 = User::create([
            'name'     => 'Erlan Kasymov',
            'email'    => 'erlan@glowbook.kz',
            'password' => Hash::make('password'),
            'role'     => 'salon_owner',
            'phone'    => '+7 701 333 3333',
        ]);

        $owner3 = User::create([
            'name'     => 'Ainur Bekova',
            'email'    => 'ainur.owner@glowbook.kz',
            'password' => Hash::make('password'),
            'role'     => 'salon_owner',
            'phone'    => '+7 701 444 4444',
        ]);

        $owner4 = User::create([
            'name'     => 'Daulet Seitkali',
            'email'    => 'daulet.owner@glowbook.kz',
            'password' => Hash::make('password'),
            'role'     => 'salon_owner',
            'phone'    => '+7 701 555 5555',
        ]);

        // ── Specialists ───────────────────────────────────────────────────────
        $specUsers = [
            User::create(['name' => 'Aigerim Satpayeva',   'email' => 'specialist@glowbook.kz',        'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 111 1111']),
            User::create(['name' => 'Dana Mukhamedova',    'email' => 'dana@glowbook.kz',              'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 222 2222']),
            User::create(['name' => 'Kamila Yerlanova',    'email' => 'kamila@glowbook.kz',            'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 333 3333']),
            User::create(['name' => 'Zhansaya Toktarova',  'email' => 'zhansaya@glowbook.kz',          'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 444 4444']),
            User::create(['name' => 'Aruzhan Bekbolatova', 'email' => 'aruzhan@glowbook.kz',           'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 555 5555']),
            User::create(['name' => 'Tomiris Altynbekova', 'email' => 'tomiris@glowbook.kz',           'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 666 6666']),
            User::create(['name' => 'Meruert Dzhaksybekova','email' => 'meruert@glowbook.kz',          'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 777 7777']),
            User::create(['name' => 'Asel Nurmagambetova', 'email' => 'asel@glowbook.kz',              'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 888 8888']),
            User::create(['name' => 'Gulnaz Ospanova',     'email' => 'gulnaz@glowbook.kz',            'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 702 999 9999']),
            User::create(['name' => 'Akmaral Seitkaliyeva','email' => 'akmaral@glowbook.kz',           'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 703 111 1111']),
            User::create(['name' => 'Sandugash Bekmuratova','email' => 'sandugash@glowbook.kz',        'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 703 222 2222']),
            User::create(['name' => 'Botakoz Zhumabayeva', 'email' => 'botakoz@glowbook.kz',           'password' => Hash::make('password'), 'role' => 'specialist', 'phone' => '+7 703 333 3333']),
        ];

        // ── Clients ───────────────────────────────────────────────────────────
        $clients = [
            User::create(['name' => 'Madina Kasymova',    'email' => 'client@glowbook.kz',         'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 111 1111']),
            User::create(['name' => 'Zhanara Temirova',   'email' => 'zhanara@glowbook.kz',        'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 222 2222']),
            User::create(['name' => 'Aliya Bekmuratova',  'email' => 'aliya@glowbook.kz',          'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 333 3333']),
            User::create(['name' => 'Nurgul Orazbekova',  'email' => 'nurgul@glowbook.kz',         'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 444 4444']),
            User::create(['name' => 'Saule Zhumabayeva',  'email' => 'saule@glowbook.kz',          'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 555 5555']),
            User::create(['name' => 'Nazgul Dzhaksybekova','email' => 'nazgul@glowbook.kz',        'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 666 6666']),
            User::create(['name' => 'Zulfiya Akhmetova',  'email' => 'zulfiya@glowbook.kz',        'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 777 7777']),
            User::create(['name' => 'Aiaru Seitkali',     'email' => 'aiaru@glowbook.kz',          'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+7 705 888 8888']),
        ];

        // ── Salons ────────────────────────────────────────────────────────────
        $salon1 = Salon::create([
            'name'        => 'Glow Studio Almaty',
            'description' => 'Premium beauty studio in the heart of Almaty. We offer top-tier beauty services with experienced professionals in a modern, elegant setting.',
            'city'        => 'Almaty',
            'address'     => 'Abay Ave 52, Almaty',
            'phone'       => '+7 727 123 4567',
            'owner_id'    => $owner1->id,
        ]);

        $salon2 = Salon::create([
            'name'        => 'Sulu Beauty Bar Astana',
            'description' => 'Trendy beauty bar in the capital with the latest techniques and premium products. Your go-to destination for nails, hair, and makeup in Astana.',
            'city'        => 'Astana',
            'address'     => 'Mangilik El Ave 34, Astana',
            'phone'       => '+7 717 987 6543',
            'owner_id'    => $owner2->id,
        ]);

        $salon3 = Salon::create([
            'name'        => 'Aizhan Salon Shymkent',
            'description' => 'A cozy and professional beauty salon in Shymkent. Full range of beauty services from haircuts to skincare, delivered by certified masters.',
            'city'        => 'Shymkent',
            'address'     => 'Tauke Khan Ave 18, Shymkent',
            'phone'       => '+7 725 234 5678',
            'owner_id'    => $owner3->id,
        ]);

        $salon4 = Salon::create([
            'name'        => 'Tengri Spa & Beauty Karaganda',
            'description' => 'Luxury spa and beauty center in Karaganda. Relax and rejuvenate with our wide selection of spa, skincare, and styling services.',
            'city'        => 'Karaganda',
            'address'     => 'Bukharzyrau Ave 77, Karaganda',
            'phone'       => '+7 721 345 6789',
            'owner_id'    => $owner4->id,
        ]);

        // ── Services ──────────────────────────────────────────────────────────
        $s1 = [
            Service::create(['name' => 'Manicure',       'description' => 'Classic or gel manicure with nail art options. Includes nail shaping, cuticle care, and polish.',            'price' => 5500,  'duration_minutes' => 60,  'category' => 'Nails',    'salon_id' => $salon1->id]),
            Service::create(['name' => 'Pedicure',       'description' => 'Relaxing pedicure with foot massage, callus removal, and polish.',                                           'price' => 7000,  'duration_minutes' => 75,  'category' => 'Nails',    'salon_id' => $salon1->id]),
            Service::create(['name' => 'Hair Coloring',  'description' => 'Professional hair coloring with premium products. Consultation, application, and styling.',                  'price' => 15000, 'duration_minutes' => 120, 'category' => 'Hair',     'salon_id' => $salon1->id]),
            Service::create(['name' => 'Haircut',        'description' => 'Precision haircut tailored to your face shape. Wash, cut, and blow-dry included.',                          'price' => 8000,  'duration_minutes' => 45,  'category' => 'Hair',     'salon_id' => $salon1->id]),
            Service::create(['name' => 'Makeup',         'description' => 'Professional makeup for any occasion. Day, evening, or bridal looks.',                                      'price' => 12000, 'duration_minutes' => 60,  'category' => 'Makeup',   'salon_id' => $salon1->id]),
            Service::create(['name' => 'Eyebrow Design', 'description' => 'Eyebrow shaping and tinting. Threading, waxing, or lamination available.',                                  'price' => 4000,  'duration_minutes' => 30,  'category' => 'Brows',    'salon_id' => $salon1->id]),
        ];

        $s2 = [
            Service::create(['name' => 'Gel Nails',         'description' => 'Long-lasting gel nail extensions with creative designs and premium gel polish.',                          'price' => 8000,  'duration_minutes' => 90,  'category' => 'Nails',    'salon_id' => $salon2->id]),
            Service::create(['name' => 'Balayage',          'description' => 'Hand-painted balayage highlights for a natural sun-kissed look.',                                         'price' => 18000, 'duration_minutes' => 150, 'category' => 'Hair',     'salon_id' => $salon2->id]),
            Service::create(['name' => 'Keratin Treatment', 'description' => 'Smoothing keratin treatment for frizz-free, silky hair that lasts up to 4 months.',                      'price' => 20000, 'duration_minutes' => 120, 'category' => 'Hair',     'salon_id' => $salon2->id]),
            Service::create(['name' => 'Bridal Makeup',     'description' => 'Complete bridal makeup package with a trial session included. Airbrush finish available.',               'price' => 25000, 'duration_minutes' => 90,  'category' => 'Makeup',   'salon_id' => $salon2->id]),
            Service::create(['name' => 'Lash Extensions',   'description' => 'Classic or volume lash extensions for a stunning eye look. Lasts 3-4 weeks.',                           'price' => 9000,  'duration_minutes' => 75,  'category' => 'Lashes',   'salon_id' => $salon2->id]),
            Service::create(['name' => 'Facial Treatment',  'description' => 'Deep cleansing facial with premium skincare products, extraction, and hydrating mask.',                  'price' => 11000, 'duration_minutes' => 60,  'category' => 'Skincare', 'salon_id' => $salon2->id]),
        ];

        $s3 = [
            Service::create(['name' => 'French Manicure',   'description' => 'Classic French manicure with a modern twist. Gel or acrylic finish options.',                            'price' => 6000,  'duration_minutes' => 60,  'category' => 'Nails',    'salon_id' => $salon3->id]),
            Service::create(['name' => 'Ombre Hair',        'description' => 'Gradient color transition from roots to tips. Customized shades for your complexion.',                   'price' => 16000, 'duration_minutes' => 120, 'category' => 'Hair',     'salon_id' => $salon3->id]),
            Service::create(['name' => 'Brow Lamination',   'description' => 'Eyebrow lamination for fluffy, perfectly shaped brows that last up to 6 weeks.',                        'price' => 5000,  'duration_minutes' => 45,  'category' => 'Brows',    'salon_id' => $salon3->id]),
            Service::create(['name' => 'Lip Makeup',        'description' => 'Professional lip makeup including lip liner and long-lasting lipstick application.',                     'price' => 3500,  'duration_minutes' => 30,  'category' => 'Makeup',   'salon_id' => $salon3->id]),
            Service::create(['name' => 'Body Massage',      'description' => 'Relaxing full-body massage using aromatic oils. Relieves tension and improves circulation.',             'price' => 14000, 'duration_minutes' => 60,  'category' => 'Spa',      'salon_id' => $salon3->id]),
            Service::create(['name' => 'Hair Straightening','description' => 'Professional hair straightening with thermal protection. Smooth, sleek results lasting months.',         'price' => 17000, 'duration_minutes' => 90,  'category' => 'Hair',     'salon_id' => $salon3->id]),
        ];

        $s4 = [
            Service::create(['name' => 'Spa Manicure',      'description' => 'Luxurious spa manicure with paraffin bath, hand massage, and premium polish.',                           'price' => 7500,  'duration_minutes' => 75,  'category' => 'Nails',    'salon_id' => $salon4->id]),
            Service::create(['name' => 'Hot Stone Massage', 'description' => 'Therapeutic hot stone massage that melts away muscle tension and stress.',                               'price' => 18000, 'duration_minutes' => 90,  'category' => 'Spa',      'salon_id' => $salon4->id]),
            Service::create(['name' => 'Anti-Age Facial',   'description' => 'Advanced anti-aging facial with collagen mask, microcurrent, and LED therapy.',                         'price' => 16000, 'duration_minutes' => 75,  'category' => 'Skincare', 'salon_id' => $salon4->id]),
            Service::create(['name' => 'Highlights',        'description' => 'Foil highlights to brighten and add dimension to your hair. Includes toner and styling.',               'price' => 14000, 'duration_minutes' => 120, 'category' => 'Hair',     'salon_id' => $salon4->id]),
            Service::create(['name' => 'Eyelash Lift',      'description' => 'Natural lash lift and tint for wide-awake eyes without extensions. Lasts 6-8 weeks.',                   'price' => 7000,  'duration_minutes' => 60,  'category' => 'Lashes',   'salon_id' => $salon4->id]),
            Service::create(['name' => 'Body Scrub',        'description' => 'Exfoliating body scrub with nourishing oils that leaves skin silky smooth.',                            'price' => 12000, 'duration_minutes' => 60,  'category' => 'Spa',      'salon_id' => $salon4->id]),
        ];

        // ── Specialists ───────────────────────────────────────────────────────
        // Salon 1 – Almaty
        $spec1 = Specialist::create(['user_id' => $specUsers[0]->id,  'salon_id' => $salon1->id, 'bio' => 'Certified nail artist with international training. Specializes in gel extensions and intricate nail art.', 'experience_years' => 7, 'rating' => 4.8]);
        $spec2 = Specialist::create(['user_id' => $specUsers[1]->id,  'salon_id' => $salon1->id, 'bio' => 'Professional hairstylist and colorist trained in Paris. Balayage and creative coloring expert.',           'experience_years' => 5, 'rating' => 4.6]);
        $spec3 = Specialist::create(['user_id' => $specUsers[2]->id,  'salon_id' => $salon1->id, 'bio' => 'Expert makeup artist and brow specialist. Works with top international beauty brands.',                    'experience_years' => 4, 'rating' => 4.9]);

        // Salon 2 – Astana
        $spec4 = Specialist::create(['user_id' => $specUsers[3]->id,  'salon_id' => $salon2->id, 'bio' => 'Gel nail specialist with a passion for creative nail art and bold designs.',                               'experience_years' => 6, 'rating' => 4.7]);
        $spec5 = Specialist::create(['user_id' => $specUsers[4]->id,  'salon_id' => $salon2->id, 'bio' => 'Hair transformation expert specializing in balayage, keratin, and color corrections.',                    'experience_years' => 8, 'rating' => 4.9]);
        $spec6 = Specialist::create(['user_id' => $specUsers[5]->id,  'salon_id' => $salon2->id, 'bio' => 'Lash and skincare specialist with advanced certification in Russian volume and Korean skincare.',          'experience_years' => 3, 'rating' => 4.5]);

        // Salon 3 – Shymkent
        $spec7 = Specialist::create(['user_id' => $specUsers[6]->id,  'salon_id' => $salon3->id, 'bio' => 'Nail technician and brow master with 5 years of experience. Known for clean finishes and creative art.',  'experience_years' => 5, 'rating' => 4.6]);
        $spec8 = Specialist::create(['user_id' => $specUsers[7]->id,  'salon_id' => $salon3->id, 'bio' => 'Hairstylist specializing in modern cuts, ombre coloring, and keratin straightening treatments.',          'experience_years' => 6, 'rating' => 4.7]);
        $spec9 = Specialist::create(['user_id' => $specUsers[8]->id,  'salon_id' => $salon3->id, 'bio' => 'Spa therapist and massage specialist. Certified in Swedish, deep-tissue, and aromatherapy massage.',      'experience_years' => 4, 'rating' => 4.8]);

        // Salon 4 – Karaganda
        $spec10 = Specialist::create(['user_id' => $specUsers[9]->id,  'salon_id' => $salon4->id, 'bio' => 'Luxury nail and spa specialist offering premium nail services alongside pampering spa treatments.',       'experience_years' => 7, 'rating' => 4.9]);
        $spec11 = Specialist::create(['user_id' => $specUsers[10]->id, 'salon_id' => $salon4->id, 'bio' => 'Anti-aging skincare expert and facial specialist trained in Korean and European skincare techniques.',    'experience_years' => 9, 'rating' => 5.0]);
        $spec12 = Specialist::create(['user_id' => $specUsers[11]->id, 'salon_id' => $salon4->id, 'bio' => 'Hair colorist and lash artist. Specializes in dimensional highlights and natural lash lift treatments.',  'experience_years' => 5, 'rating' => 4.7]);

        // ── Service assignments ───────────────────────────────────────────────
        $spec1->services()->attach([$s1[0]->id, $s1[1]->id]);
        $spec2->services()->attach([$s1[2]->id, $s1[3]->id]);
        $spec3->services()->attach([$s1[4]->id, $s1[5]->id]);

        $spec4->services()->attach([$s2[0]->id]);
        $spec5->services()->attach([$s2[1]->id, $s2[2]->id]);
        $spec6->services()->attach([$s2[3]->id, $s2[4]->id, $s2[5]->id]);

        $spec7->services()->attach([$s3[0]->id, $s3[2]->id, $s3[3]->id]);
        $spec8->services()->attach([$s3[1]->id, $s3[5]->id]);
        $spec9->services()->attach([$s3[4]->id]);

        $spec10->services()->attach([$s4[0]->id, $s4[1]->id, $s4[5]->id]);
        $spec11->services()->attach([$s4[2]->id]);
        $spec12->services()->attach([$s4[3]->id, $s4[4]->id]);

        // ── Appointments ──────────────────────────────────────────────────────
        $appointments = [
            // Upcoming – confirmed
            Appointment::create(['client_id' => $clients[0]->id, 'specialist_id' => $spec1->id,  'service_id' => $s1[0]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->addDays(1)->toDateString(),  'appointment_time' => '10:00', 'status' => 'confirmed', 'notes' => 'Gel manicure with French tips']),
            Appointment::create(['client_id' => $clients[1]->id, 'specialist_id' => $spec2->id,  'service_id' => $s1[2]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->addDays(1)->toDateString(),  'appointment_time' => '14:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clients[2]->id, 'specialist_id' => $spec4->id,  'service_id' => $s2[0]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->addDays(2)->toDateString(),  'appointment_time' => '11:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clients[3]->id, 'specialist_id' => $spec5->id,  'service_id' => $s2[1]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->addDays(3)->toDateString(),  'appointment_time' => '13:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clients[4]->id, 'specialist_id' => $spec7->id,  'service_id' => $s3[0]->id, 'salon_id' => $salon3->id, 'appointment_date' => now()->addDays(2)->toDateString(),  'appointment_time' => '09:30', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clients[5]->id, 'specialist_id' => $spec8->id,  'service_id' => $s3[1]->id, 'salon_id' => $salon3->id, 'appointment_date' => now()->addDays(4)->toDateString(),  'appointment_time' => '15:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clients[6]->id, 'specialist_id' => $spec10->id, 'service_id' => $s4[0]->id, 'salon_id' => $salon4->id, 'appointment_date' => now()->addDays(1)->toDateString(),  'appointment_time' => '11:30', 'status' => 'confirmed', 'notes' => 'Spa manicure with paraffin']),
            Appointment::create(['client_id' => $clients[7]->id, 'specialist_id' => $spec11->id, 'service_id' => $s4[2]->id, 'salon_id' => $salon4->id, 'appointment_date' => now()->addDays(5)->toDateString(),  'appointment_time' => '16:00', 'status' => 'confirmed']),

            // Past – completed (reviewable)
            Appointment::create(['client_id' => $clients[0]->id, 'specialist_id' => $spec2->id,  'service_id' => $s1[3]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->subDays(3)->toDateString(),  'appointment_time' => '15:00', 'status' => 'completed']),   // [8]
            Appointment::create(['client_id' => $clients[1]->id, 'specialist_id' => $spec3->id,  'service_id' => $s1[4]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->subDays(5)->toDateString(),  'appointment_time' => '12:00', 'status' => 'completed']),   // [9]
            Appointment::create(['client_id' => $clients[2]->id, 'specialist_id' => $spec5->id,  'service_id' => $s2[2]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(7)->toDateString(),  'appointment_time' => '10:00', 'status' => 'completed']),   // [10]
            Appointment::create(['client_id' => $clients[3]->id, 'specialist_id' => $spec6->id,  'service_id' => $s2[5]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(2)->toDateString(),  'appointment_time' => '15:30', 'status' => 'completed']),   // [11]
            Appointment::create(['client_id' => $clients[4]->id, 'specialist_id' => $spec9->id,  'service_id' => $s3[4]->id, 'salon_id' => $salon3->id, 'appointment_date' => now()->subDays(4)->toDateString(),  'appointment_time' => '14:00', 'status' => 'completed']),   // [12]
            Appointment::create(['client_id' => $clients[5]->id, 'specialist_id' => $spec8->id,  'service_id' => $s3[5]->id, 'salon_id' => $salon3->id, 'appointment_date' => now()->subDays(6)->toDateString(),  'appointment_time' => '11:00', 'status' => 'completed']),   // [13]
            Appointment::create(['client_id' => $clients[6]->id, 'specialist_id' => $spec11->id, 'service_id' => $s4[2]->id, 'salon_id' => $salon4->id, 'appointment_date' => now()->subDays(8)->toDateString(),  'appointment_time' => '10:30', 'status' => 'completed']),   // [14]
            Appointment::create(['client_id' => $clients[7]->id, 'specialist_id' => $spec12->id, 'service_id' => $s4[3]->id, 'salon_id' => $salon4->id, 'appointment_date' => now()->subDays(10)->toDateString(), 'appointment_time' => '13:00', 'status' => 'completed']),   // [15]
            Appointment::create(['client_id' => $clients[0]->id, 'specialist_id' => $spec6->id,  'service_id' => $s2[4]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(14)->toDateString(), 'appointment_time' => '09:00', 'status' => 'completed']),   // [16]
            Appointment::create(['client_id' => $clients[3]->id, 'specialist_id' => $spec1->id,  'service_id' => $s1[1]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->subDays(9)->toDateString(),  'appointment_time' => '12:00', 'status' => 'completed']),   // [17]

            // Past – cancelled
            Appointment::create(['client_id' => $clients[4]->id, 'specialist_id' => $spec6->id,  'service_id' => $s2[4]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(1)->toDateString(),  'appointment_time' => '09:30', 'status' => 'cancelled']),
            Appointment::create(['client_id' => $clients[2]->id, 'specialist_id' => $spec7->id,  'service_id' => $s3[2]->id, 'salon_id' => $salon3->id, 'appointment_date' => now()->subDays(3)->toDateString(),  'appointment_time' => '16:00', 'status' => 'cancelled']),

            // Today
            Appointment::create(['client_id' => $clients[1]->id, 'specialist_id' => $spec3->id,  'service_id' => $s1[5]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->toDateString(),              'appointment_time' => '11:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clients[6]->id, 'specialist_id' => $spec9->id,  'service_id' => $s3[4]->id, 'salon_id' => $salon3->id, 'appointment_date' => now()->toDateString(),              'appointment_time' => '14:30', 'status' => 'confirmed']),
        ];

        // ── Reviews ───────────────────────────────────────────────────────────
        Review::create(['client_id' => $clients[0]->id, 'specialist_id' => $spec2->id,  'appointment_id' => $appointments[8]->id,  'rating' => 5, 'comment' => 'Dana is an amazing stylist! My hair looks absolutely perfect. Will definitely come back.']);
        Review::create(['client_id' => $clients[1]->id, 'specialist_id' => $spec3->id,  'appointment_id' => $appointments[9]->id,  'rating' => 5, 'comment' => 'Kamila did incredible makeup for my event. Everyone was asking who did it!']);
        Review::create(['client_id' => $clients[2]->id, 'specialist_id' => $spec5->id,  'appointment_id' => $appointments[10]->id, 'rating' => 5, 'comment' => 'Best keratin treatment ever! Aruzhan is so professional and the results lasted 4 months.']);
        Review::create(['client_id' => $clients[3]->id, 'specialist_id' => $spec6->id,  'appointment_id' => $appointments[11]->id, 'rating' => 4, 'comment' => 'Lovely facial, my skin felt so refreshed. Tomiris explained every step. Very professional.']);
        Review::create(['client_id' => $clients[4]->id, 'specialist_id' => $spec9->id,  'appointment_id' => $appointments[12]->id, 'rating' => 5, 'comment' => 'Gulnaz gives the best body massage in Shymkent. So relaxing, I fell asleep on the table!']);
        Review::create(['client_id' => $clients[5]->id, 'specialist_id' => $spec8->id,  'appointment_id' => $appointments[13]->id, 'rating' => 4, 'comment' => 'Great hair straightening result. Asel was careful and thorough. Lasts really well.']);
        Review::create(['client_id' => $clients[6]->id, 'specialist_id' => $spec11->id, 'appointment_id' => $appointments[14]->id, 'rating' => 5, 'comment' => 'Sandugash is a skincare genius. The anti-age facial made me look 5 years younger. Absolutely worth it!']);
        Review::create(['client_id' => $clients[7]->id, 'specialist_id' => $spec12->id, 'appointment_id' => $appointments[15]->id, 'rating' => 5, 'comment' => 'Botakoz did perfect highlights. Natural, dimensional, exactly what I wanted. Very happy!']);
        Review::create(['client_id' => $clients[0]->id, 'specialist_id' => $spec6->id,  'appointment_id' => $appointments[16]->id, 'rating' => 4, 'comment' => 'Beautiful lash extensions, very natural looking. Tomiris was precise and quick.']);
        Review::create(['client_id' => $clients[3]->id, 'specialist_id' => $spec1->id,  'appointment_id' => $appointments[17]->id, 'rating' => 5, 'comment' => 'Aigerim is truly a nail artist. My pedicure was perfect. Super clean and relaxing experience.']);

        // ── Update ratings & factory data ─────────────────────────────────────
        Specialist::all()->each(fn($s) => $s->updateRating());
        Appointment::factory(120)->create();
        Review::factory(60)->create();
        Specialist::all()->each(fn($s) => $s->updateRating());
    }
}
