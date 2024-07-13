<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notifications::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return NotificationResource::collection($notifications);
    }

    public function show(Notifications $notification)
    {
        if(! $notification)
        {
            return response()->json(['error' => 'Notification not found'], 404);
        }
        $user = Auth::user();

        if ($notification->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return new NotificationResource($notification);
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read', 200]);
    }
}
