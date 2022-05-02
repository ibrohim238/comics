<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\User;
use App\Notifications\ChapterCreated;
use Illuminate\Support\Facades\Notification;

class ChapterNotificationService
{
    public function create(Chapter $chapter)
    {
        $users = User::all();

        Notification::send($users, new ChapterCreated($this->prepareData($chapter)));
    }

    protected function prepareData(Chapter $chapter): array
    {
        $manga = $chapter->manga;
        $type = $chapter->is_paid ? 'бесплатном' : 'платном';

        return [
            'image' => $manga->getFirstMediaUrl(),
            'message' => "$manga->name добавлен $chapter->volume том $chapter->number глава в $type доступе.",
            'url' => route('manga.show', $manga),
            'group_id' => $manga->id
        ];
    }
}
