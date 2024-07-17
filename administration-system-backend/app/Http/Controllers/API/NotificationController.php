<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getAllNotifications()
    {
        return response()->json(auth('api')->user()->notifications);
    }

    public function getUnreadNotifications()
    {
        return response()->json(auth('api')->user()->unreadNotifications);
    }

    public function markNotificationAsRead(string $id)
    {
        if($id != 0) {
            auth('api')->user()->notifications->where('id', $id)->markAsRead();
        }else{
            auth('api')->user()->notifications->markAsRead();
        }
        return response()->json('success');
    }
    
    public function clearAllNotifications()
    {
        auth('api')->user()->notifications()->delete();
        return response()->json('success');
    }
}
