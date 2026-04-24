<?php

namespace App\Policies;

use App\Models\Specialist;
use App\Models\User;

class SpecialistPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function create(User $user): bool
    {
        return $user->isSalonOwner();
    }

    public function delete(User $user, Specialist $specialist): bool
    {
        return $user->isSalonOwner()
            && $specialist->salon->owner_id === $user->id;
    }
}
