<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;

class PostPolicy
{
    public function before(Authenticatable $user, $ability)
    {
        // اگر کاربر Admin از گارد admin است
        if ($user instanceof Admin) {
            return true; // دسترسی کامل
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('author|editor');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole('author')) {
            return $user->id === $post->user_id;
        }

        // Editor همه پست‌ها
        if ($user->hasRole('editor')) {
            return true; // Editor همه پست‌ها
        }

        return false;
    }

    public function updateAny(User $user): bool
    {
        return Post::query()
            ->where('user_id', $user->id)
            ->exists()
            || $user->hasRole('editor|author');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole('editor')) {
            return true; // Editor همه پست‌ها
        }

        if ($user->hasRole('author')) {
            return $user->id === $post->user_id; // Author فقط پست خودش
        }

        return false;
    }

}
