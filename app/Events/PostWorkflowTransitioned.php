<?php

namespace App\Events;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PostWorkflowTransitioned
{
    use Dispatchable;
    use SerializesModels;

    public $post;
    public $fromStatus;
    public $toStatus;

    public function __construct(Post $post, PostStatus $fromStatus, PostStatus $toStatus)
    {
        $this->post = $post;
        $this->fromStatus = $fromStatus;
        $this->toStatus = $toStatus;
    }
}
