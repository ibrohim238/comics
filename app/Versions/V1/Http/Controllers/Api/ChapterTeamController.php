<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterTeamDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\ChapterTeamRequest;
use App\Versions\V1\Http\Resources\ChapterTeamCollection;
use App\Versions\V1\Http\Resources\ChapterTeamResource;
use App\Versions\V1\Repository\ChapterTeamRepository;
use App\Versions\V1\Services\ChapterTeamService;
use Illuminate\Http\Request;

class ChapterTeamController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ChapterTeam::class);
    }

    public function index(
        Manga   $manga,
        Chapter $chapter,
        Request $request
    )
    {
        $chapterTeams = app(ChapterTeamRepository::class, [
            'chapterTeam' => $chapter->chapterTeams()
        ])->paginate($request->get('count'));

        return new ChapterTeamCollection($chapterTeams);
    }

    public function show(
        Manga       $manga,
        Chapter     $chapter,
        ChapterTeam $chapterTeam
    )
    {
        return new ChapterTeamResource(
            app(ChapterTeamRepository::class, [
                'chapterTeam' => $chapterTeam
            ])->load()
        );
    }

    public function store(
        Manga              $manga,
        Chapter            $chapter,
        Team               $team,
        ChapterTeamRequest $request
    )
    {
        $chapterTeam = app(ChapterTeamService::class)
            ->create($chapter, $team, ChapterTeamDto::fromRequest($request));

        return new ChapterTeamResource($chapterTeam);
    }

    public function update(
        Manga              $manga,
        Chapter            $chapter,
        ChapterTeam        $chapterTeam,
        ChapterTeamRequest $request
    )
    {
        app(ChapterTeamService::class, [
            'chapterTeam' => $chapterTeam
        ])->update(ChapterTeamDto::fromRequest($request));

        return new ChapterTeamResource($chapterTeam);
    }

    public function destroy(Manga $manga, Chapter $chapter, ChapterTeam $chapterTeam)
    {
        app(ChapterTeamService::class, [
            'chapterTeam' => $chapterTeam
        ])->delete();

        return response()->noContent();
    }
}
