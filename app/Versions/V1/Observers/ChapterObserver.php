<?php

namespace App\Versions\V1\Observers;

use App\Enums\EventTypeEnum;
use App\Models\Chapter;
use App\Models\User;
use App\Notifications\ChapterCreated;
use App\Versions\V1\Services\ChapterNotificationService;
use App\Versions\V1\Services\EventService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use function app;

class ChapterObserver
{
    /**
     * Handle the Chapter "created" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function created(Chapter $chapter)
    {
        app(EventService::class)->create($chapter, Auth::user(), EventTypeEnum::CREATE_TYPE);
        app(ChapterNotificationService::class)->create($chapter);
    }

    /**
     * Handle the Chapter "updated" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function updated(Chapter $chapter)
    {
        app(EventService::class)->create($chapter, Auth::user(), EventTypeEnum::UPDATE_TYPE);
        app(ChapterNotificationService::class)->create($chapter);
    }

    /**
     * Handle the Chapter "deleted" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function deleted(Chapter $chapter)
    {
        app(EventService::class)->create($chapter, Auth::user(), EventTypeEnum::DELETE_TYPE);
    }

    /**
     * Handle the Chapter "restored" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function restored(Chapter $chapter)
    {
        //
    }

    /**
     * Handle the Chapter "force deleted" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function forceDeleted(Chapter $chapter)
    {
        //
    }
}
