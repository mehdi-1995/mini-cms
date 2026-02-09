<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\ViewModels\Post\PostEditViewModel;
use App\ViewModels\Post\PostIndexViewModel;
use App\ViewModels\Post\PostCreateViewModel;
use App\Http\Requests\PostRequest\PostStoreRequest;
use App\Http\Requests\PostRequest\PostUpdateRequest;

class PostController extends Controller
{
    public function __construct(private PostService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Post::class);
        $posts = $this->service->getAllPaginated();
        $vm = new PostIndexViewModel($posts, request()->routeIs('admin.*'));
        return view('posts.index', $vm->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        $vm = new PostCreateViewModel();
        return view('posts.create', $vm->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        try {
            $actor = auth()->user() ?? auth('admin')->user();
            $this->service->store($request->validated(), $actor);
            $route = $actor instanceof Admin
                ? 'admin.posts.index'
                : 'posts.index';
            return redirect()
                ->route($route)
                ->with('success', __('messages.post_created'));
        } catch (\Exception $e) {
            report($e);
            return back()
                ->withInput()
                ->with('error', __('messages.post_create_failed'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        dd($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $vm = new PostEditViewModel($post, request()->routeIs('admin.*'));
        return view('posts.edit', compact('vm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        try {
            $actor = auth()->user() ?? auth('admin')->user();
            $this->service->update($request->validated(), $post, $actor);
            $route = $actor instanceof Admin
                ? 'admin.posts.index'
                : 'posts.index';
            return redirect()
            ->route($route)
            ->with('success', __('messages.post_updated'));
        } catch (\Throwable $e) {
            abort($e);
            return back()
                ->withInput()
                ->with('error', __('messages.post_update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
