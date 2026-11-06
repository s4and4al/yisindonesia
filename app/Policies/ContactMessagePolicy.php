<?php

namespace App\Policies;

use App\Models\ContactMessage;
use App\Models\User;

class ContactMessagePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function view(User $user, ContactMessage $message): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function update(User $user, ContactMessage $message): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function delete(User $user, ContactMessage $message): bool
    {
        return $user->role === 'admin';
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}
