<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\User;
use App\Notifications\ChapterCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class ChapterNotificationService
{
    public function create(Chapter $chapter)
    {
        User::whereHas('mangas', function (Builder $builder) use ($chapter) {
            $builder->where('id', $chapter->manga_id);
        })->chunk(100, function (Collection $users) use ($chapter) {
            Notification::send($users, new ChapterCreated($chapter));
        });
    }
}
