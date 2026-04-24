<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Specialist;
use App\Policies\AppointmentPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\SalonPolicy;
use App\Policies\ServicePolicy;
use App\Policies\SpecialistPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(Salon::class, SalonPolicy::class);
        Gate::policy(Service::class, ServicePolicy::class);
        Gate::policy(Appointment::class, AppointmentPolicy::class);
        Gate::policy(Review::class, ReviewPolicy::class);
        Gate::policy(Specialist::class, SpecialistPolicy::class);
    }
}
