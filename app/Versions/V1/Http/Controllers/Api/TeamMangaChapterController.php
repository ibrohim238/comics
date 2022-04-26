<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\ChapterIndexRequest;
use App\Versions\V1\Http\Requests\Api\ChapterRequest;
use App\Versions\V1\Http\Resources\ChapterCollection;
use App\Versions\V1\Http\Resources\ChapterResource;
use App\Versions\V1\Services\ChapterService;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TeamMangaChapterController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Team $team, Manga $manga)
    {
//        $this->authorize('viewAny');

        $chapters = $manga->chapters()
            ->where('team_id', $team)
            ->get();

        return new ChapterCollection($chapters);
    }

    /**
     * @throws UnknownProperties
     * @throws AuthorizationException
     */
    public function store(Team $team, Manga $manga, ChapterRequest $request)
    {
        $this->authorize('create', [Chapter::class, $team]);

        $chapter = app(ChapterService::class, [new Chapter()])
            ->create(ChapterDto::fromRequest($request), $team, $manga);

        return new ChapterResource($chapter);
    }

    /**
     * @throws UnknownProperties
     * @throws AuthorizationException
     */
    public function update(Team $team, Manga $manga, Chapter $chapter, ChapterRequest $request)
    {
        $this->authorize('update', [$chapter, $team]);

        app(ChapterService::class, [$chapter])
            ->update(ChapterDto::fromRequest($request));

        return new ChapterResource($chapter);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Team $team, Manga $manga, Chapter $chapter)
    {
        $this->authorize('delete', [$chapter, $team]);

        app(ChapterService::class, [$chapter])->delete();

        return response()->noContent();
    }
}
