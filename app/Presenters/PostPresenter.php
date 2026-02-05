<?php

namespace App\Presenters;

use App\Models\Post;

class PostPresenter
{
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function indexRout()
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.index') : route('posts.index');
    }

    public function createRout()
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.create') : route('posts.create');
    }

    public function storeRout()
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.store')
        : route('posts.store');
    }

    public function editRout()
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.edit', $this->post->id)
        : route('posts.edit', $this->post->id);
    }

    public function updateRout()
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.update', $this->post->id)
        : route('posts.update', $this->post->id);
    }

    public function destroyRout()
    {
        return auth()->guard('admin')->check()
        ? route('admin.posts.destroy', $this->post->id)
        : route('posts.destroy', $this->post->id);
    }

    public function title()
    {
        return $this->post->title;
    }

    public function published()
    {
        return $this->post->published;
    }

}
