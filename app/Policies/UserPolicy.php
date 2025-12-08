<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{

    public function view(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function add(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    public function update(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

}
