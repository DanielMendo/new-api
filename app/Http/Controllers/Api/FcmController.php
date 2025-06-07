<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\FcmToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FcmController extends Controller
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = User::find(Auth::id());
        $token = $request->fcm_token;


        $existingToken = FcmToken::where('user_id', $user->id)->where('token', $token)->first();

        if (!$existingToken) {

            FcmToken::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);
        } else {

            $existingToken->touch();
        }

        return response()->json(['message' => 'FCM Token actualizado correctamente'], 200);
    }

    public function deleteDeviceToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = User::find(Auth::id());
        $token = $request->fcm_token;

        $existingToken = FcmToken::where('user_id', $user->id)->where('token', $token)->first();

        if (!$existingToken) {
            return response()->json(['error' => 'No se encontró token FCM para el usuario'], 400);
        }

        $existingToken->delete();

        return response()->json(['message' => 'FCM Token eliminado correctamente'], 200);
    }

    // Enviar notificación a todos los tokens asociados a un user_id
    public function sendFcmNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|url',
        ]);

        $user = User::find($request->user_id);
        $tokens = FcmToken::where('user_id', $user->id)->pluck('token')->all();

        if (empty($tokens)) {
            return response()->json(['error' => 'No se encontraron tokens FCM para el usuario'], 400);
        }

        $notification = Notification::create($request->title, $request->body);
        $data = [
            'image' => $request->image ?? '',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        ];

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
        }

        return response()->json(['message' => 'Notificaciones enviadas correctamente']);
    }

    public function sendLikeNotification(Post $post, User $liker)
    {
        $tokens = FcmToken::where('user_id', $post->user_id)->pluck('token')->all();

        if (empty($tokens)) return;

        $title = "{$liker->name} le dio like a tu publicación:";
        $body = ' ' . Str::limit($post->title) . ' ';
        $imageUrl = $post->image ?? '';

        // $notification = Notification::create($title, $body);

        $data = [
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl,
            'layout' => 'BigPicture',
            'channelKey' => 'basic_channel',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        ];

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                // ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
        }
    }

    public function sendCommentNotification(Post $post, User $commenter, string $commentText)
    {
        $tokens = FcmToken::where('user_id', $post->user_id)->pluck('token')->all();

        if (empty($tokens)) return;

        $title = "{$commenter->name} comentó en tu publicación: {$post->title}";
        $body = Str::limit($commentText, 50);
        $imageUrl = $post->image ?? '';
        // $notification = Notification::create($title, $body);

        $data = [
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl,
            'layout' => 'BigPicture',
            'channelKey' => 'basic_channel',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        ];

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                // ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
        }
    }

    public function sendFollowNotification(User $followed, User $follower)
    {
        $tokens = FcmToken::where('user_id', $followed->id)->pluck('token')->all();

        if (empty($tokens)) return;

        $title = "{$follower->name} comenzó a seguirte.";
        $body = "Ahora tienes un nuevo seguidor.";

        $image = $follower->profile_image ?? 'profile/avatar.png';
        $imageUrl = config('app.url') . '/storage/' . $image;

        // $notification = Notification::fromArray([
        //     'title' => $title,
        //     'body' => $body,
        //     'image' => $imageUrl,
        // ]);

        $data = [
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl,
            'layout' => 'Default',
            'channelKey' => 'basic_channel',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        ];

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                // ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
        }
    }



    // Enviar notificación a todos los usuarios suscritos a un topic
    public function sendTopicNotification(Request $request)
    {
        $request->validate([
            'topic' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|url',
        ]);

        $message = CloudMessage::withTarget('topic', $request->topic)
            ->withNotification(Notification::create($request->title, $request->body))
            ->withData([
                'image' => $request->image ?? '',
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ]);

        $this->messaging->send($message);

        return response()->json(['message' => 'Notificación de topic enviada correctamente']);
    }
}
