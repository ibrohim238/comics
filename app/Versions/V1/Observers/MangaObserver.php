<?php

namespace App\Versions\V1\Observers;

use App\Enums\EnumTypeEnum;
use App\Models\Manga;
use App\Versions\V1\Services\EventService;
use Illuminate\Support\Facades\Auth;
use function app;

class MangaObserver
{
    /**
     * Handle the Manga "created" event.
     *
     * @param Manga $manga
     * @return void
     */
    public function created(Manga $manga)
    {
        app(EventService::class)->create($manga, Auth::user(), EnumTypeEnum::CREATE_TYPE);
    }

    /**
     * Handle the Manga "updated" event.
     *
     * @param Manga $manga
     * @return void
     */
    public function updated(Manga $manga)
    {
        app(EventService::class)->create($manga, Auth::user(), EnumTypeEnum::UPDATE_TYPE);
    }

    /**
     * Handle the Manga "deleted" event.
     *
     * @param Manga $manga
     * @return void
     */
    public function deleted(Manga $manga)
    {
        app(EventService::class)->create($manga, Auth::user(), EnumTypeEnum::DELETE_TYPE);
    }

    /**
     * Handle the Manga "restored" event.
     *
     * @param Manga $manga
     * @return void
     */
    public function restored(Manga $manga)
    {
        //
    }

    /**
     * Handle the Manga "force deleted" event.
     *
     * @param Manga $manga
     * @return void
     */
    public function forceDeleted(Manga $manga)
    {
        //
    }
}
