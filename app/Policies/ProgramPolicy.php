<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;

class ProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function view(User $user, Program $program): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function update(User $user, Program $program): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function delete(User $user, Program $program): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function deleteAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }
}
