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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->whereNull('read_at', 'and', $request->get('viewed', false))
            ->lastPerGroup('data->group_id', 'baseId')
            ->toSql();


        dd($notifications);

        return new NotificationCollection($notifications);
    }

    public function more($groupId, Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->whereNull('read_at', 'and', $request->get('viewed', false))
            ->where('data->group_id', $groupId)
            ->paginate($request->get('count'));

        /* @var LengthAwarePaginator $notifications*/
        $notifications
            ->transform(
                fn(DatabaseNotification $notification): NotificationDto => app(NotificationTransformer::class)
                    ->transform($notification)
            );

        return new NotificationCollection($notifications);
    }

    public function read(Notification $notification)
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->read($notification);
    }

    public function unread(Notification $notification)
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->unRead($notification);
    }

    public function readSet(array $ids)
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->readSet($ids);
    }

    public function unReadSet(array $ids)
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->unReadSet($ids);
    }

    public function readAll()
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->readAll();
    }
}
