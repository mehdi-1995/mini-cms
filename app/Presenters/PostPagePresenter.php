<?php

namespace App\Presenters;

use App\Models\Post;

class PostPagePresenter
{
    public function indexRoute()
    {
        return auth()->guard('admin')->check()
            ? route('admin.posts.index')
            : route('posts.index');
    }

    public function createRoute()
    {
        return auth()->guard('admin')->check()
            ? route('admin.posts.create')
            : route('posts.create');
    }

    public function storeRoute()
    {
        return auth()->guard('admin')->check()
            ? route('admin.posts.store')
            : route('posts.store');
    }
}

