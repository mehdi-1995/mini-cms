<?php

namespace App\Listeners;

use App\Events\PostWorkflowTransitioned;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPostWorkflowNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostWorkflowTransitioned $event): void
    {
        //
    }
}
