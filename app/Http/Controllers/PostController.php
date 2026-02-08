<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\ViewModels\Post\PostIndexViewModel;
use App\ViewModels\Post\PostCreateViewModel;
use App\Http\Requests\PostRequest\PostStoreRequest;

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
        $vm = new PostIndexViewModel($posts);
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
            $user = auth()->user() ?? auth('admin')->user();
            $this->service->store($request->validated(), $user);
            return redirect()
                ->route('posts.index')
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
        // return view();
        dd($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
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
