<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function getAllPaginated($perPage = 6): LengthAwarePaginator
    {
        return Post::with('user')->paginate($perPage);
    }

    public function getAllPublished($perPage = 6)
    {
        return Post::where('published', 1)->latest()->paginate($perPage);
    }

    public function store(array $data, Authenticatable $actor)
    {
        return Post::create([
            'title'     => $data['title'],
            'content'   => $data['content'],
            'published' => $data['published'] ?? false,
            'user_id'   => $actor instanceof User ? $actor->id : null,
        ]);
    }
}
