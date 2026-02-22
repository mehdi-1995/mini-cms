<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PostCreatedNotification extends Notification
{
    use Queueable;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // ارسال هم ایمیل هم ذخیره در دیتابیس
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Post Created')
            ->line("A new post titled '{$this->post->title}' has been created.")
            ->action('View Post', url("/posts/{$this->post->id}"));
    }

    public function toDatabase($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'message' => "Post '{$this->post->title}' created.",
        ];
    }
}
