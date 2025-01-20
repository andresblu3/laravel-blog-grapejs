<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'designer']);
    }

    public function update(User $user, Post $post): bool
    {
        return $user->hasRole('admin') || 
               ($user->hasRole('designer') && $user->id === $post->user_id);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasRole('admin') || 
               ($user->hasRole('designer') && $user->id === $post->user_id);
    }

    public function publish(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('publish posts');
    }

    public function unpublish(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('unpublish posts');
    }
} 