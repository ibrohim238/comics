<?php

namespace App\Observers;

use App\Enums\EnumTypeEnum;
use App\Models\Chapter;
use App\Versions\V1\Services\EventService;
use Illuminate\Support\Facades\Auth;

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
        app(EventService::class)->create($chapter, Auth::user(), EnumTypeEnum::CREATE_TYPE);
    }

    /**
     * Handle the Chapter "updated" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function updated(Chapter $chapter)
    {
        app(EventService::class)->create($chapter, Auth::user(), EnumTypeEnum::UPDATE_TYPE);
    }

    /**
     * Handle the Chapter "deleted" event.
     *
     * @param Chapter $chapter
     * @return void
     */
    public function deleted(Chapter $chapter)
    {
        app(EventService::class)->create($chapter, Auth::user(), EnumTypeEnum::DELETE_TYPE);
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
