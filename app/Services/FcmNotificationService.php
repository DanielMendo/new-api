<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\User;
use App\Models\FcmToken;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FcmNotificationService
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendLikeNotification(Post $post, User $liker)
    {
        $tokens = FcmToken::where('user_id', $post->user_id)->pluck('token')->all();

        if (empty($tokens)) return;

        $title = "{$liker->name} le dio like a tu publicación";
        $body = Str::limit($post->contenido, 50);

        $notification = Notification::create($title, $body);

        $data = [
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'post_id' => $post->id,
        ];

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
        }
    }
}
