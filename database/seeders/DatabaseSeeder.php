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
\App\Models\Salon::factory(10)->create();

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Аслан Нурланов',
            'email' => 'admin@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+7 701 111 1111',
        ]);

        $owner = User::create([
            'name' => 'Динара Абдрахманова',
            'email' => 'owner@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'salon_owner',
            'phone' => '+7 701 222 2222',
        ]);

        $owner2 = User::create([
            'name' => 'Ерлан Касымов',
            'email' => 'erlan@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'salon_owner',
            'phone' => '+7 701 333 3333',
        ]);

        $specUser1 = User::create([
            'name' => 'Айгерим Сатпаева',
            'email' => 'specialist@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'specialist',
            'phone' => '+7 702 222 2222',
        ]);

        $specUser2 = User::create([
            'name' => 'Дана Мухамедова',
            'email' => 'dana@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'specialist',
            'phone' => '+7 703 333 3333',
        ]);

        $specUser3 = User::create([
            'name' => 'Камила Ерланова',
            'email' => 'kamila@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'specialist',
            'phone' => '+7 704 444 4444',
        ]);

        $specUser4 = User::create([
            'name' => 'Жансая Токтарова',
            'email' => 'zhansaya@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'specialist',
            'phone' => '+7 702 555 5555',
        ]);

        $specUser5 = User::create([
            'name' => 'Аружан Бекболатова',
            'email' => 'aruzhan@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'specialist',
            'phone' => '+7 703 666 6666',
        ]);

        $specUser6 = User::create([
            'name' => 'Томирис Алтынбекова',
            'email' => 'tomiris@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'specialist',
            'phone' => '+7 704 777 7777',
        ]);

        $clientUser1 = User::create([
            'name' => 'Мадина Касымова',
            'email' => 'client@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+7 705 555 5555',
        ]);

        $clientUser2 = User::create([
            'name' => 'Жанара Темирова',
            'email' => 'zhanara@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+7 706 666 6666',
        ]);

        $clientUser3 = User::create([
            'name' => 'Алия Бекмуратова',
            'email' => 'aliya@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+7 707 777 7777',
        ]);

        $clientUser4 = User::create([
            'name' => 'Нұргүл Оразбекова',
            'email' => 'nurgul@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+7 708 888 8888',
        ]);

        $clientUser5 = User::create([
            'name' => 'Сауле Жумабаева',
            'email' => 'saule@glowbook.kz',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+7 709 999 9999',
        ]);

        $salon1 = Salon::create([
            'name' => 'Glow Studio Almaty',
            'description' => 'Premium beauty studio in the heart of Almaty. We offer top-tier beauty services with experienced professionals in a modern, elegant setting.',
            'address' => 'ул. Абая 52, Алматы',
            'phone' => '+7 727 123 4567',
            'owner_id' => $owner->id,
        ]);

        $salon2 = Salon::create([
            'name' => 'Beauty Bar Astana',
            'description' => 'Trendy beauty bar with the latest techniques and products. Your go-to destination for nails, hair, and makeup in Astana.',
            'address' => 'пр. Мангилик Ел 34, Астана',
            'phone' => '+7 717 987 6543',
            'owner_id' => $owner2->id,
        ]);

        $s1services = [
            Service::create(['name' => 'Manicure', 'description' => 'Classic or gel manicure with nail art options. Includes nail shaping, cuticle care, and polish.', 'price' => 5500, 'duration_minutes' => 60, 'category' => 'Nails', 'salon_id' => $salon1->id]),
            Service::create(['name' => 'Pedicure', 'description' => 'Relaxing pedicure with foot massage, callus removal, and polish.', 'price' => 7000, 'duration_minutes' => 75, 'category' => 'Nails', 'salon_id' => $salon1->id]),
            Service::create(['name' => 'Hair Coloring', 'description' => 'Professional hair coloring with premium products. Consultation, application, and styling.', 'price' => 15000, 'duration_minutes' => 120, 'category' => 'Hair', 'salon_id' => $salon1->id]),
            Service::create(['name' => 'Haircut', 'description' => 'Precision haircut tailored to your face shape. Wash, cut, and blow-dry.', 'price' => 8000, 'duration_minutes' => 45, 'category' => 'Hair', 'salon_id' => $salon1->id]),
            Service::create(['name' => 'Makeup', 'description' => 'Professional makeup for any occasion. Day, evening, or bridal looks.', 'price' => 12000, 'duration_minutes' => 60, 'category' => 'Makeup', 'salon_id' => $salon1->id]),
            Service::create(['name' => 'Eyebrow Design', 'description' => 'Eyebrow shaping and tinting. Threading, waxing, or lamination.', 'price' => 4000, 'duration_minutes' => 30, 'category' => 'Brows', 'salon_id' => $salon1->id]),
        ];

        $s2services = [
            Service::create(['name' => 'Gel Nails', 'description' => 'Long-lasting gel nail extensions with creative designs.', 'price' => 8000, 'duration_minutes' => 90, 'category' => 'Nails', 'salon_id' => $salon2->id]),
            Service::create(['name' => 'Balayage', 'description' => 'Hand-painted balayage highlights for a natural sun-kissed look.', 'price' => 18000, 'duration_minutes' => 150, 'category' => 'Hair', 'salon_id' => $salon2->id]),
            Service::create(['name' => 'Keratin Treatment', 'description' => 'Smoothing keratin treatment for frizz-free, silky hair.', 'price' => 20000, 'duration_minutes' => 120, 'category' => 'Hair', 'salon_id' => $salon2->id]),
            Service::create(['name' => 'Bridal Makeup', 'description' => 'Complete bridal makeup package with trial session included.', 'price' => 25000, 'duration_minutes' => 90, 'category' => 'Makeup', 'salon_id' => $salon2->id]),
            Service::create(['name' => 'Lash Extensions', 'description' => 'Classic or volume lash extensions for stunning eyes.', 'price' => 9000, 'duration_minutes' => 75, 'category' => 'Lashes', 'salon_id' => $salon2->id]),
            Service::create(['name' => 'Facial Treatment', 'description' => 'Deep cleansing facial with premium skincare products.', 'price' => 11000, 'duration_minutes' => 60, 'category' => 'Skincare', 'salon_id' => $salon2->id]),
        ];

        $spec1 = Specialist::create(['user_id' => $specUser1->id, 'salon_id' => $salon1->id, 'bio' => 'Certified nail artist with international training. Specializes in gel extensions and nail art.', 'experience_years' => 7, 'rating' => 4.8]);
        $spec2 = Specialist::create(['user_id' => $specUser2->id, 'salon_id' => $salon1->id, 'bio' => 'Professional hairstylist and colorist trained in Paris. Balayage and creative coloring expert.', 'experience_years' => 5, 'rating' => 4.6]);
        $spec3 = Specialist::create(['user_id' => $specUser3->id, 'salon_id' => $salon1->id, 'bio' => 'Expert makeup artist and brow specialist. Works with top beauty brands.', 'experience_years' => 4, 'rating' => 4.9]);

        $spec4 = Specialist::create(['user_id' => $specUser4->id, 'salon_id' => $salon2->id, 'bio' => 'Gel nail specialist with a passion for creative nail art and design.', 'experience_years' => 6, 'rating' => 4.7]);
        $spec5 = Specialist::create(['user_id' => $specUser5->id, 'salon_id' => $salon2->id, 'bio' => 'Hair transformation expert. Specializes in balayage and keratin treatments.', 'experience_years' => 8, 'rating' => 4.9]);
        $spec6 = Specialist::create(['user_id' => $specUser6->id, 'salon_id' => $salon2->id, 'bio' => 'Lash and skincare specialist with advanced certification.', 'experience_years' => 3, 'rating' => 4.5]);

        $spec1->services()->attach([$s1services[0]->id, $s1services[1]->id]);
        $spec2->services()->attach([$s1services[2]->id, $s1services[3]->id]);
        $spec3->services()->attach([$s1services[4]->id, $s1services[5]->id]);
        $spec4->services()->attach([$s2services[0]->id, $s2services[1]->id]);
        $spec5->services()->attach([$s2services[1]->id, $s2services[2]->id]);
        $spec6->services()->attach([$s2services[3]->id, $s2services[4]->id, $s2services[5]->id]);

        $appointments = [
            Appointment::create(['client_id' => $clientUser1->id, 'specialist_id' => $spec1->id, 'service_id' => $s1services[0]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->addDays(1)->toDateString(), 'appointment_time' => '10:00', 'status' => 'confirmed', 'notes' => 'Gel manicure with French tips']),
            Appointment::create(['client_id' => $clientUser2->id, 'specialist_id' => $spec2->id, 'service_id' => $s1services[2]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->addDays(1)->toDateString(), 'appointment_time' => '14:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clientUser3->id, 'specialist_id' => $spec4->id, 'service_id' => $s2services[0]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->addDays(2)->toDateString(), 'appointment_time' => '11:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clientUser1->id, 'specialist_id' => $spec2->id, 'service_id' => $s1services[3]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->subDays(3)->toDateString(), 'appointment_time' => '15:00', 'status' => 'completed']),
            Appointment::create(['client_id' => $clientUser4->id, 'specialist_id' => $spec1->id, 'service_id' => $s1services[1]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->subDays(5)->toDateString(), 'appointment_time' => '12:00', 'status' => 'completed']),
            Appointment::create(['client_id' => $clientUser5->id, 'specialist_id' => $spec6->id, 'service_id' => $s2services[4]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(1)->toDateString(), 'appointment_time' => '09:30', 'status' => 'cancelled']),
            Appointment::create(['client_id' => $clientUser2->id, 'specialist_id' => $spec5->id, 'service_id' => $s2services[2]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(7)->toDateString(), 'appointment_time' => '10:00', 'status' => 'completed']),
            Appointment::create(['client_id' => $clientUser3->id, 'specialist_id' => $spec2->id, 'service_id' => $s1services[2]->id, 'salon_id' => $salon1->id, 'appointment_date' => now()->toDateString(), 'appointment_time' => '16:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clientUser4->id, 'specialist_id' => $spec5->id, 'service_id' => $s2services[1]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->addDays(3)->toDateString(), 'appointment_time' => '13:00', 'status' => 'confirmed']),
            Appointment::create(['client_id' => $clientUser1->id, 'specialist_id' => $spec6->id, 'service_id' => $s2services[5]->id, 'salon_id' => $salon2->id, 'appointment_date' => now()->subDays(2)->toDateString(), 'appointment_time' => '15:30', 'status' => 'completed']),
        ];

        Review::create(['client_id' => $clientUser1->id, 'specialist_id' => $spec2->id, 'appointment_id' => $appointments[3]->id, 'rating' => 5, 'comment' => 'Дана — потрясающий стилист! Мои волосы выглядят идеально.']);
        Review::create(['client_id' => $clientUser4->id, 'specialist_id' => $spec1->id, 'appointment_id' => $appointments[4]->id, 'rating' => 4, 'comment' => 'Замечательный педикюр, очень аккуратно. Will come again!']);
        Review::create(['client_id' => $clientUser2->id, 'specialist_id' => $spec5->id, 'appointment_id' => $appointments[6]->id, 'rating' => 5, 'comment' => 'Best keratin treatment ever! Аружан is amazing.']);
        Review::create(['client_id' => $clientUser1->id, 'specialist_id' => $spec6->id, 'appointment_id' => $appointments[9]->id, 'rating' => 5, 'comment' => 'Wonderful facial! My skin feels incredible. Highly recommend Томирис.']);
            Specialist::all()->each(fn($s) => $s->updateRating());
             Appointment::factory(100)->create();
            Review::factory(50)->create();
            Specialist::all()->each(fn($s) => $s->updateRating());
        }


}
