<?php

namespace App\Versions\V1\Observers;

use App\Enums\EventTypeEnum;
use App\Models\ChapterTeam;
use App\Versions\V1\Services\ChapterNotificationService;
use App\Versions\V1\Services\EventService;
use Illuminate\Support\Facades\Auth;

class ChapterTeamObserver
{
    /**
     * Handle the Chapter "created" event.
     *
     * @param ChapterTeam $chapterTeam
     * @return void
     */
    public function created(ChapterTeam $chapterTeam)
    {
        app(EventService::class)->create($chapterTeam, Auth::user(), EventTypeEnum::CREATE_TYPE);
        app(ChapterNotificationService::class)->create($chapterTeam);
    }

    /**
     * Handle the Chapter "updated" event.
     *
     * @param ChapterTeam $chapterTeam
     * @return void
     */
    public function updated(ChapterTeam $chapterTeam)
    {
        app(EventService::class)->create($chapterTeam, Auth::user(), EventTypeEnum::UPDATE_TYPE);
        app(ChapterNotificationService::class)->create($chapterTeam);
    }

    /**
     * Handle the Chapter "deleted" event.
     *
     * @param ChapterTeam $chapterTeam
     * @return void
     */
    public function deleted(ChapterTeam $chapterTeam)
    {
        app(EventService::class)->create($chapterTeam, Auth::user(), EventTypeEnum::DELETE_TYPE);
    }

    /**
     * Handle the Chapter "restored" event.
     *
     * @param ChapterTeam $chapterTeam
     * @return void
     */
    public function restored(ChapterTeam $chapterTeam)
    {
        //
    }

    /**
     * Handle the Chapter "force deleted" event.
     *
     * @param ChapterTeam $chapterTeam
     * @return void
     */
    public function forceDeleted(ChapterTeam $chapterTeam)
    {
        //
    }
}
