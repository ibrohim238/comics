<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\User;
use App\Notifications\ChapterCreated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class ChapterNotificationService
{
    public function create(Chapter $chapter)
    {
        $users = $this->getUsersWithManga($chapter->manga_id);

        Notification::send($users, new ChapterCreated($chapter));
    }

    public function getUsersWithManga(int $mangaId): Collection
    {
        //@TODO: change that
        return User::all();
    }
}
