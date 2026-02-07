<?php

namespace App\ViewModels\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\LengthAwarePaginator;

class PostIndexViewModel
{
    public function __construct(
        public LengthAwarePaginator $posts
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
        return auth()->guard('admin')->check()
            ? route('admin.posts.create')
            : route('posts.create');
    }

    public function editRoute(Post $post): string
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.edit', $post)
        : route('posts.edit', $post);
    }

    public function destroyRoute(Post $post): string
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.destroy', $post)
        : route('posts.destroy', $post);
    }

    public function rows()
    {
        return $this->posts
            ->through(fn ($post) => new PostRowViewModel($post));
    }

    public function paginator()
    {
        return $this->posts;
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
