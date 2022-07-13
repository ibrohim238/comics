<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\NotificationDto;
use App\Models\Notification;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\NotificationCollection;
use App\Versions\V1\Http\Resources\NotificationResource;
use App\Versions\V1\Services\NotificationService;
use App\Versions\V1\Transformers\NotificationTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request): NotificationCollection
    {
        $notifications = Auth::user()->notifications()
            ->whereNull('read_at', 'and', $request->get('viewed', false))
            ->lastPerGroup('data->group_id', 'baseId')
            ->paginate($request->get('count'));

        /* @var LengthAwarePaginator $notifications*/
        $notifications
            ->transform(
                fn(DatabaseNotification $notification): NotificationDto => app(NotificationTransformer::class)
                    ->transform($notification)
            );

        return new NotificationCollection($notifications);
    }

    public function more($groupId, Request $request): NotificationCollection
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

    public function read(Notification $notification): Response
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->read($notification);

        return response()->noContent();
    }

    public function unread(Notification $notification): Response
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->unRead($notification);

        return response()->noContent();
    }

    public function readSet(array $ids): Response
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->readSet($ids);

        return response()->noContent();
    }

    public function unReadSet(array $ids): Response
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->unReadSet($ids);

        return response()->noContent();
    }

    public function readAll(): Response
    {
        app(NotificationService::class, [
            'user' => Auth::user()
        ])->readAll();

        return response()->noContent();
    }
}
