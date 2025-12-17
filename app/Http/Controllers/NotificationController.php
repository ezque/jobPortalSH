<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function viewAdminNotification()
    {
        $userId = auth()->id();

        Notification::where('receiver_id', $userId)
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        $notifications = Notification::where('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin.notification', compact('notifications'));
    }
    public function viewUserNotification()
    {
        $userId = Auth::id();

        Notification::where('receiver_id', $userId)
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        $notifications = Notification::where('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('User.user-notification', compact('notifications'));
    }
    public function deleteNotification($id)
    {
        $notification = Notification::where('id', $id)
            ->where('receiver_id', auth()->id()) // ensure only their own notifications
            ->firstOrFail();

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully.');
    }
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('receiver_id', auth()->id())
            ->firstOrFail();

        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function unreadNotificationCount()
    {
        $count = Notification::unread()
            ->where('receiver_id', Auth::id())
            ->count();

        return response()->json([
            'count' => $count
        ]);
    }
}
