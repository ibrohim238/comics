<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\NotificationCollection;
use App\Versions\V1\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public User $user;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->where('type', $request->get('type', false))
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
        app(NotificationService::class, [Auth::user()])->read($id);
    }

    public function unread($id)
    {
        app(NotificationService::class, [Auth::user()])->unRead($id);
    }

    public function readSet(array $ids)
    {
        app(NotificationService::class, [Auth::user()])->readSet($ids);
    }

    public function unReadSet(array $ids)
    {
        app(NotificationService::class, [Auth::user()])->unReadSet($ids);
    }

    public function readAll()
    {
        app(NotificationService::class, [Auth::user()])->readAll();
    }
}
