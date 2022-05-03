<?php

namespace App\Versions\V1\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class NotificationService
{
    public function __construct(
        public User $user
    ) {
    }

    public function read(int $id): void
    {
        $this->get($id)->markAsRead();
    }

    public function unRead(int $id): void
    {
        $this->get($id)->markAsUnread();
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

    protected function get($id): Model|MorphMany|null
    {
        return $this->user->notifications()->where('id', $id)->first();
    }

    protected function getCollection(array $ids): Collection
    {
        return $this->user->notifications()->whereIn('id', $ids)->get();
    }
}
