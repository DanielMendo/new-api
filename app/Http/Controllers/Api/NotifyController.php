<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->user()->notifications,
        ]);
    }

    public function markRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'Notificaciones leidas correctamente',
        ], 200);
    }

    public function count(Request $request)
    {
        return response()->json([
            'count' => $request->user()->unreadNotifications()->count(),
        ], 200);
    }
}
