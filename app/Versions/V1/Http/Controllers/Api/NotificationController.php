<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Notification;
use App\Versions\V1\Dto\NotificationDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\NotificationCollection;
use App\Versions\V1\Services\NotificationService;
use App\Versions\V1\Transformers\NotificationTransformer;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->lastPerGroup('data->group_id', 'baseId')
            ->paginate($request->get('count'));

        $notifications
            ->getCollection()
            ->transform(
                fn(DatabaseNotification $notification): NotificationDto => app(NotificationTransformer::class)
                    ->transform($notification)
            );

        return new NotificationCollection($notifications);
    }

    public function more(Notification $notification)
    {
        $notifications = Auth::user()->notifications()
            ->where('data->group_id', $notification->data->group_id)
            ->orderByDesc('created_at')
            ->get();

        return new NotificationCollection($notifications);
    }

    public function read(Notification $notification)
    {
        app(NotificationService::class, [Auth::user()])->read($notification);
    }

    public function unread(Notification $notification)
    {
        app(NotificationService::class, [Auth::user()])->unRead($notification);
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
