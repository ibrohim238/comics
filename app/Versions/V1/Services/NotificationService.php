<?php

namespace App\Versions\V1\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class NotificationService
{
    public function read(Notification $notification): void
    {
        $notification->markAsRead();
    }

    public function unRead(Notification $notification): void
    {
        $notification->markAsUnread();
    }

    public function readSet(User $user, array $ids): void
    {
        $this->getCollection($user, $ids)->markAsRead();
    }

    public function unReadSet(User $user, array $ids): void
    {
        $this->getCollection($user, $ids)->markAsUnread();
    }

    public function readAll(User $user)
    {
        $user->unreadNotifications->markAsRead();
    }

    protected function getCollection(User $user, array $ids): MorphMany
    {
        return $user->notifications()->whereIn('id', $ids);
    }
}
