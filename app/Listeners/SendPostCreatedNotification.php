<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\PostCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPostCreatedNotification implements ShouldQueue
{
    public function handle(PostCreated $event)
    {
        // برای مثال، notify همه admin ها
        $admins = \App\Models\Admin::role(['super-admin','admin'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new PostCreatedNotification($event->post));
        }
    }
}
