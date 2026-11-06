<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor', 'author'], true);
    }

    public function view(User $user, Post $post): bool
    {
        return in_array($user->role, ['admin', 'editor'], true)
            || ($user->role === 'author' && $post->author_id === $user->id);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor', 'author'], true);
    }

    public function update(User $user, Post $post): bool
    {
        if (in_array($user->role, ['admin', 'editor'], true)) {
            return true;
        }

        return $user->role === 'author'
            && $post->author_id === $user->id
            && in_array($post->status, ['draft', 'review'], true);
    }

    public function delete(User $user, Post $post): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }

    public function deleteAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor'], true);
    }
}
