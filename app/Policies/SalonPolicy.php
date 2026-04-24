<?php

namespace App\Policies;

use App\Models\Salon;
use App\Models\User;

class SalonPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Salon $salon): bool
    {
        return $salon->owner_id === $user->id;
    }

    public function delete(User $user, Salon $salon): bool
    {
        return false;
    }
}
