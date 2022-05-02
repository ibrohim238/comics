<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\NotificationCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public User $user;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->user = Auth::user();
    }

    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->select('*')
            ->groupBy('data->group_id')
            ->get();

        return new NotificationCollection($notifications);
    }

    public function more($groupId)
    {
        $notifications = Auth::user()->notifications()
            ->where('data->group_id', $groupId)
            ->orderByDesc('created_at')
            ->get();

        return new NotificationCollection($notifications);
    }

    public function read($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
    }

    public function unread($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        $notification->markAsUnread();
    }

    public function readSet(array $ids)
    {
        $notifications = $this->user->notifications()->whereIn('id', $ids)->get();

        $notifications->markAsRead();
    }

    public function unReadSet(array $ids)
    {
        $notifications = $this->user->notifications()->whereIn('id', $ids)->get();

        $notifications->markAsUnread();
    }

    public function readAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }
}
