<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
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

    public function update(User $user, Service $service): bool
    {
        return $user->isSalonOwner() && $service->salon->owner_id === $user->id;
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->isSalonOwner() && $service->salon->owner_id === $user->id;
    }
}
