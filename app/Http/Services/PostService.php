<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Presenters\PostPresenter;

class PostService
{
    public function getAll()
    {
        return Post::all()->map(fn($post)=> PostPresenter($post));
    }

    public function getAllPublished($perPage = 6)
    {
        return Post::where('published', 1)->latest()->paginate($perPage);
    }

    public function store()
    {
    }
}
