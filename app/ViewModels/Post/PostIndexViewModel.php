<?php

namespace App\ViewModels\Post;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class PostIndexViewModel
{
    public function __construct(
        public LengthAwarePaginator $posts,
        public bool $isAdmin = false,
    ) {
    }

    public function canManagePosts(): bool
    {
        return Gate::allows('updateAny', Post::class);
    }

    public function canCreate(): bool
    {
        return Gate::allows('create', Post::class);
    }

    public function createRoute(): string
    {
        return $this->isAdmin
            ? route('admin.posts.create')
            : route('posts.create');
    }

    // public function rows(): Collection
    // {
    //     return $this->posts
    //     ->getCollection()
    //     ->map(fn ($post) => new PostRowViewModel($post));
    // }

    // public function paginator()
    // {
    //     return $this->posts;
    // }

    public function rows(): LengthAwarePaginator
    {
        return $this->posts
            ->through(fn ($post) => new PostRowViewModel($post,$this->isAdmin));
    }

    public function toArray(): array
    {
        return [
            'posts' => $this->posts,
            'rows'  => $this->rows(),
            'vm'    => $this,
        ];
    }
}
