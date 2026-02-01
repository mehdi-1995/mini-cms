<?php

namespace App\Http\Services;

use App\Models\Post;

class PostService
{
    public function getAll()
    {
        return Post::all();
    }

    public function store()
    {
    }
}
