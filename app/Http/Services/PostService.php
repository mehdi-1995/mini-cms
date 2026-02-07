<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Presenters\PostPresenter;

class PostService
{
    public function getAll($perPage = 6)
    {
        // return Post::paginate($perPage)
        // ->through(fn (Post $post) => $post->present());
        // return Post::paginate($perPage)->map(fn (Post $post) => $post->present());
        // return Post::all()->through(fn (Post $post) => new PostPresenter($post));
        return Post::with('user')->paginate($perPage);
    }

    public function getAllPublished($perPage = 6)
    {
        return Post::where('published', 1)->latest()->paginate($perPage);
    }

    public function store()
    {
    }
}
