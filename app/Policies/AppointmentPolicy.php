<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function view(User $user, Appointment $appointment): bool
    {
        if ($user->isClient()) return $appointment->client_id === $user->id;

        if ($user->isSpecialist()) {
            return $appointment->specialist_id === optional($user->specialist)->id;
        }

        if ($user->isSalonOwner()) {
            return $appointment->salon->owner_id === $user->id;
        }

        return false;
    }

    public function updateStatus(User $user, Appointment $appointment): bool
    {
        return $user->isSpecialist()
            && $appointment->specialist_id === optional($user->specialist)->id;
    }

    public function review(User $user, Appointment $appointment): bool
    {
        return $user->isClient()
            && $appointment->client_id === $user->id;
    }
}
