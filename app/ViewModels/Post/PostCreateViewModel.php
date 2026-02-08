<?php

namespace App\ViewModels\Post;

class PostCreateViewModel
{
    public function storeRout()
    {
        return request()->routeIs('admin.*')
            ? route('admin.posts.store')
            : route('posts.store');
    }

    public function indexRout()
    {
        return request()->routeIs('admin.*')
            ? route('admin.posts.index')
            : route('posts.index');
    }

    public function toArray()
    {
        return [
            'vm' => $this
        ];
    }
}
