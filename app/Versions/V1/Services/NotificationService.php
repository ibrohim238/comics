<?php

namespace App\Versions\V1\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class NotificationService
{
    public function __construct(
        public User $user
    ) {
    }

    public function read(Notification $notification): void
    {
        $notification->markAsRead();
    }

    public function unRead(Notification $notification): void
    {
        $notification->markAsUnread();
    }

    public function readSet(array $ids): void
    {
        $this->getCollection($ids)->markAsRead();
    }

    public function unReadSet(array $ids): void
    {
        $this->getCollection($ids)->markAsUnread();
    }

    public function readAll()
    {
        $this->user->unreadNotifications->markAsRead();
    }

    protected function getCollection(array $ids): MorphMany
    {
        return $this->user->notifications()->whereIn('id', $ids);
    }
}
