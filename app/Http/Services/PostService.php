<?php

namespace App\Http\Services;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\PostCannotBeDeletedException;
use DomainException;

class PostService
{
    public function getAllPaginated($perPage = 6): LengthAwarePaginator
    {
        return Post::with('user')->paginate($perPage);
    }

    public function getAllPublished($perPage = 6)
    {
        return Post::where('published', 1)->latest()->paginate($perPage);
    }

    public function store(array $data, Authenticatable $actor)
    {
        return Post::create([
            'title'     => $data['title'],
            'content'   => $data['content'],
            'published' => $data['published'] ?? false,
            'user_id'   => $actor instanceof User ? $actor->id : null,
        ]);
    }

    public function update(array $data, Post $post, Authenticatable $actor)
    {
        if ($actor instanceof User) {
            $data['user_id'] = $actor->id;
        }

        if ($actor instanceof Admin) {
            $data['user_id'] = null;
        }

        $post->update($data);

        return $post;
    }

    public function destroy(Post $post)
    {
        DB::transaction(function () use ($post) {

            if ($post->published) {
                throw new PostCannotBeDeletedException('Published posts cannot be deleted.');
            }

            // اگر فردا کامنت اضافه شد
            // if ($post->comments()->exists()) {
            //     throw new PostCannotBeDeletedException('Post has comments.');
            // }

            if (! $post->delete()) {
                throw new \RuntimeException('Post deletion failed.');
            }
        });
    }

    public function submitForReview(Post $post): Post
    {
        if ($post->status !== PostStatus::Draft) {
            throw new DomainException('Post is not draft.');
        }

        $post->update([
            'status' => PostStatus::Review,
        ]);

        return $post;
    }

    public function publish(Post $post, ?Authenticatable $user = null): void
    {
        if ($user instanceof Admin) {
            $post->update([
                'status' => PostStatus::Published,
            ]);
            return;
        }

        if ($post->status !== PostStatus::Review) {
            throw new DomainException('Post is not ready to publish.');
        }

        $post->update([
            'status' => PostStatus::Published,
        ]);
    }
}
