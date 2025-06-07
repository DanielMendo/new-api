<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentNotification extends Notification
{
    use Queueable;
    public $post;
    public $commenter;
    public $commentText;

    /**
     * Create a new notification instance.
     */
    public function __construct($post, $commenter, $commentText)
    {
        $this->post = $post;
        $this->commenter = $commenter;
        $this->commentText = $commentText;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->post->id,
            'title' => "{$this->commenter->name} comentó en tu publicación: {$this->post->title}",
            'body' => Str::limit($this->commentText, 50),
            'image' => $this->post->image,
            'type' => 'post',
            'user' => null
        ];
    }
}
