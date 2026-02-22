<?php

namespace App\Http\Controllers;

use DomainException;
use App\Models\Post;
use App\Models\Admin;
use App\Http\Services\PostService;
use App\Http\Services\PostWorkflowService;
use App\ViewModels\Post\PostEditViewModel;
use App\ViewModels\Post\PostIndexViewModel;
use App\ViewModels\Post\PostCreateViewModel;
use App\Exceptions\PostCannotBeDeletedException;
use App\Http\Requests\PostRequest\PostStoreRequest;
use App\Http\Requests\PostRequest\PostUpdateRequest;

class PostController extends Controller
{
    public function __construct(private PostService $service, private PostWorkflowService $Workflow)
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
        $this->authorize('create', Post::class);
        $actor = auth()->user() ?? auth('admin')->user();
        try {

            $post = $this->service->store($request->validated(), $actor);

            // if ($request->boolean('publish_action')) {
            //     if ($actor instanceof User && $actor->isAuthor()) {
            //         $this->authorize('submit', $post);
            //         $this->Workflow->submitForReview($post);
            //     } else {
            //         $this->authorize('publish', $post);
            //         $this->Workflow->publish($post, $actor);
            //     }
            // }

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
        $actor = auth()->user() ?? auth('admin')->user();
        try {
            $this->service->update($request->validated(), $post, $actor);

            // if ($request->boolean('publish_action')) {
            //     if ($actor instanceof User && $actor->isAuthor()) {
            //         $this->authorize('submit', $post);
            //         $this->Workflow->submitForReview($post);
            //     } else {
            //         $this->authorize('publish', $post);
            //         $this->Workflow->publish($post, $actor);
            //     }
            // }

            $route = $actor instanceof Admin
                ? 'admin.posts.index'
                : 'posts.index';

            return redirect()
            ->route($route)
            ->with('success', __('messages.post_updated'));

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with('error', __('messages.post_update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        try {

            $this->service->destroy($post);
            return back()
                ->with('success', __('messages.post_deleted'));

        } catch (PostCannotBeDeletedException $e) {

            return back()->with('error', $e->getMessage());

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->with('error', __('messages.post_delete_failed'));
        }
    }

    public function submit(Post $post)
    {
        $this->authorize('submit', $post);
        try {
            $this->Workflow->submitForReview($post);
            return back()
                   ->with('success', __('messages.post_submitted_successfully'));
        } catch (DomainException $e) {
            abort(403);
        }
    }

    public function publish(Post $post)
    {
        $this->authorize('publish', $post);
        $user = auth()->user() ?: auth('admin')->user();
        try {
            $this->Workflow->publish($post, $user);
            return redirect()
                 ->back()
                 ->with('success', 'Post published successfully.');
        } catch (DomainException $e) {
            abort(403);
        }
    }

}
