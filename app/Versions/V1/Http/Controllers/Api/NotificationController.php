<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Versions\V1\Dto\NotificationDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\NotificationCollection;
use App\Versions\V1\Services\NotificationService;
use App\Versions\V1\Transformers\NotificationTransformer;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->lastPerGroup('data->group_id')
            ->paginate()
            ->transform(
                fn(DatabaseNotification $notification): NotificationDto => app(NotificationTransformer::class)
                    ->transform($notification)
            );

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
