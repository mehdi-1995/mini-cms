<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts       = Post::count();
        $publishedPosts   = Post::where('published', true)->count();
        $draftPosts       = Post::where('published', false)->count();
        $totalUsers       = User::count();
        $latestPosts      = Post::latest()->take(5)->get();
        $canManagePosts   = Gate::allows('updateAny', Post::class);

        return view('dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'totalUsers',
            'latestPosts',
            'canManagePosts'
        ));
    }
}
