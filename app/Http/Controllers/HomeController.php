<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PostService;

class HomeController extends Controller
{
    public function __construct(private PostService $service)
    {
    }
    public function index()
    {
        $posts = $this->service->getAllPublished(); // فقط پست‌های منتشر شده
        return view('home', compact('posts'));
    }
}
