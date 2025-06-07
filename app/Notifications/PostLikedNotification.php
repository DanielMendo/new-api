<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostLikedNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $liker;

    /**
     * Create a new notification instance.
     */
    public function __construct($post, $liker)
    {
        $this->post = $post;
        $this->liker = $liker;
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
            'title' => "{$this->liker->name} le dio like a tu publicación:",
            'body' => Str::limit($this->post->title, 50),
            'image' => $this->post->image,
            'type' => 'post',
            'user' => null
        ];
    }
}
