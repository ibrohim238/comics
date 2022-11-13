<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Notification;
use App\Versions\V1\Dto\NotificationDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\NotificationRequest;
use App\Versions\V1\Http\Resources\NotificationCollection;
use App\Versions\V1\Services\NotificationService;
use App\Versions\V1\Transformers\NotificationTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use function app;
use function response;

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

    public function read(Notification $notification)
    {
        app(NotificationService::class)->read($notification);

        return response()->json();
    }

    public function unread(Notification $notification)
    {
        app(NotificationService::class)->unRead($notification);

        return response()->json();
    }

    public function readSet(NotificationRequest $request)
    {
        app(NotificationService::class)->readSet(Auth::user(), $request->ids);

        return response()->json();
    }

    public function unReadSet(NotificationRequest $request)
    {
        app(NotificationService::class)->unReadSet(Auth::user(), $request->ids);

        return response()->json();
    }

    public function readAll()
    {
        app(NotificationService::class)->readAll(Auth::user());

        return response()->json();
    }
}
