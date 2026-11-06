<?php

namespace App\Policies;

use App\Models\PostCategory;
use App\Models\User;

class PostCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function view(User $user, PostCategory $category): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function update(User $user, PostCategory $category): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function delete(User $user, PostCategory $category): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function deleteAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }
}
