<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts       = Post::count();
        $publishedPosts   = Post::where('published', true)->count();
        $draftPosts       = Post::where('published', false)->count();
        $totalUsers       = User::count();
        $latestPosts      = Post::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'totalUsers',
            'latestPosts'
        ));
    }
}
