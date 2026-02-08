<?php

// app/ViewModels/Post/PostRowViewModel.php

namespace App\ViewModels\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostRowViewModel
{
    public function __construct(
        protected Post $post
    ) {
    }

    public function title(): string
    {
        return $this->post->title;
    }

    public function isPublished(): bool
    {
        return (bool) $this->post->published;
    }

    public function authorName(): string
    {
        return $this->post->user->name ?? 'نامشخص';
    }

    public function canUpdate(): bool
    {
        return Gate::allows('update', $this->post);
    }

    public function canDelete(): bool
    {
        return Gate::allows('delete', $this->post);
    }

    public function editRoute(): string
    {
        return request()->routeIs('admin.*')
        ? route('admin.posts.edit', $this->post)
        : route('posts.edit', $this->post);
    }

    public function destroyRoute(): string
    {
        return request()->routeIs('admin.*')
        ? route('admin.posts.destroy', $this->post)
        : route('posts.destroy', $this->post);
    }
}
