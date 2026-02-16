<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;

class PostPolicy
{
    private function isAdmin(Authenticatable $actor): bool
    {
        return $actor instanceof Admin;
    }

    private function isUser(Authenticatable $actor): bool
    {
        return $actor instanceof User;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $actor): bool
    {
        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($this->isUser($actor)) {

            if (! $actor instanceof User) {
                return false;
            }

            return $actor->hasRole('author') || $actor->hasRole('editor');
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $actor, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $actor): bool
    {

        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($this->isUser($actor)) {

            if (! $actor instanceof User) {
                return false;
            }

            return $actor->hasAnyRole(['author', 'editor']);
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $actor, Post $post): bool
    {

        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($this->isUser($actor)) {

            if (! $actor instanceof User) {
                return false;
            }

            if ($actor->hasRole('author')) {
                return $actor->id === $post->user_id;
            }

            // Editor همه پست‌ها
            if ($actor->hasRole('editor')) {
                return true; // Editor همه پست‌ها
            }

        }

        return false;
    }

    public function updateAny(Authenticatable $actor): bool
    {

        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($this->isUser($actor)) {

            if (! $actor instanceof User) {
                return false;
            }

            return $actor->hasRole('editor');
        }

        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $actor, Post $post): bool
    {
        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($this->isUser($actor)) {
            if (! $actor instanceof User) {
                return false;
            }

            if ($actor->hasRole('editor')) {
                return true; // Editor همه پست‌ها
            }

            if ($actor->hasRole('author')) {
                return $actor->id === $post->user_id; // Author فقط پست خودش
            }
        }

        return false;
    }

    public function submit(Authenticatable $actor, Post $post): bool
    {
        if ($this->isAdmin($actor)) {
            return true;
        }

        if ($this->isUser($actor)) {
            if (! $actor instanceof User) {
                return false;
            }
            return $actor->isAuthor()
            && $post->user_id === $actor->id;
        }

        return false;
    }

    public function publish(Authenticatable $actor, Post $post): bool
    {
        if ($this->isAdmin($actor)) {
            return true;
        }
        if ($this->isUser($actor)) {
            if (! $actor instanceof User) {
                return false;
            }
            return $actor->isEditor();
        }

        return false;
    }

}
