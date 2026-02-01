<?php

namespace App\Http\Services;

use App\Models\Post;

class PostService
{
    public function getAll()
    {
        return Post::all();
    }

    public function getAllPublished($perPage = 6)
    {
        return Post::where('published', 1)->latest()->paginate($perPage);
    }

    public function store()
    {
    }
}
