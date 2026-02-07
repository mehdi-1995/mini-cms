<?php

// app/ViewModels/Post/PostRowViewModel.php

namespace App\ViewModels\Post;

use App\Models\Post;

class PostRowViewModel
{
    public function __construct(
        protected Post $post
    ) {}

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

    public function post(): Post
    {
        return $this->post; // اگر هنوز جایی خود مدل لازم شد
    }
}
