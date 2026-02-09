<?php

namespace App\ViewModels\Post;

use App\Models\Post;

class PostEditViewModel
{
    public function __construct(
        private Post $post,
        private bool $isAdmin = false
    ) {
    }

    public function updateRoute(): string
    {
        return $this->isAdmin
            ? route('admin.posts.update', $this->post)
            : route('posts.update', $this->post);
    }

    public function indexRoute(): string
    {
        return $this->isAdmin
            ? route('admin.posts.index')
            : route('posts.index');
    }

    public function title(): string
    {
        return $this->post->title;
    }

    public function isPublished(): bool
    {
        return (bool) $this->post->published;
    }

    public function content(): string
    {
        return $this->post->content;
    }


    public function toArray(): array
    {
        return ['vm' => $this];
    }
}
