<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function before(User $user, $ability)
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
        if ($user instanceof Admin) {
            return true; // Admin می‌تواند ایجاد کند
        }

        // برای گارد User: فقط author و editor
        return $user->hasRole('author|editor');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user instanceof Admin) {
            return true; // Admin همه پست‌ها
        }

        // Author فقط پست خودش
        if ($user->hasRole('author')) {
            return $user->id === $post->user_id;
        }

        // Editor همه پست‌ها
        if ($user->hasRole('editor')) {
            return true; // Editor همه پست‌ها
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user instanceof Admin) {
            return true; // Admin همه پست‌ها
        }

        if ($user->hasRole('editor')) {
            return true; // Editor همه پست‌ها
        }

        if ($user->hasRole('author')) {
            return $user->id === $post->user_id; // Author فقط پست خودش
        }

        return false;
    }

}
