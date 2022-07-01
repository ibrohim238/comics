<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\User;
use App\Notifications\ChapterCreated;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class ChapterNotificationService
{
    public function create(ChapterTeam $chapterTeam)
    {
        User::whereHas('mangas', function (Builder $builder) use ($chapterTeam) {
            $builder->where('id', $chapterTeam->chapter->manga_id);
        })->chunk(100, function (Collection $users) use ($chapterTeam) {
            Notification::send($users, new ChapterCreated($chapterTeam->chapter));
        });
    }
}
