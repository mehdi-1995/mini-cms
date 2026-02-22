<?php

namespace App\Http\Services;

use DomainException;
use App\Models\Post;
use App\Models\Admin;
use App\Enums\PostStatus;
use App\Events\PostWorkflowTransitioned;
use Illuminate\Contracts\Auth\Authenticatable;

class PostWorkflowService
{
    public function submitForReview(Post $post): Post
    {
        if ($post->status !== PostStatus::Draft) {
            throw new DomainException('Post is not draft.');
        }

        $from = $post->status;

        $post->update([
            'status' => PostStatus::Review,
        ]);

        PostWorkflowTransitioned::dispatch($post, $from, PostStatus::Review);
        
        return $post;
    }

    public function publish(Post $post, Authenticatable $user): void
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
