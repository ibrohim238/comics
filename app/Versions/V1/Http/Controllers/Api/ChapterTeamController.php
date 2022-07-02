<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Manga;
use App\Versions\V1\Dto\ChapterTeamDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\ChapterTeamRequest;
use App\Versions\V1\Http\Resources\ChapterTeamCollection;
use App\Versions\V1\Http\Resources\ChapterTeamResource;
use App\Versions\V1\Repository\ChapterTeamRepository;
use App\Versions\V1\Services\ChapterTeamService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ChapterTeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * @throws AuthorizationException
     */
    public function index(
        Manga   $manga,
        Chapter $chapter,
        Request $request
    )
    {
        $this->authorize('viewAny', ChapterTeam::class);

        $chapterTeams = app(Срф::class, [
            'chapterTeam' => $chapter->chapterTeams()
        ])->paginate($request->get('count'));

        return new ChapterTeamCollection($chapterTeams);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(
        Manga       $manga,
        Chapter     $chapter,
        ChapterTeam $chapterTeam
    )
    {
        $this->authorize('view', $chapterTeam);

        return new ChapterTeamResource(
            app(ChapterTeamRepository::class, [
                'chapterTeam' => $chapterTeam
            ])->load()->getChapter()
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function store(
        Manga              $manga,
        Chapter            $chapter,
        ChapterTeamRequest $request
    )
    {
        $this->authorize('create', [ChapterTeam::class, $request->teamId]);

        $chapterTeam = app(ChapterTeamService::class)
            ->updateOrCreate($chapter, ChapterTeamDto::fromRequest($request));

        return new ChapterTeamResource($chapterTeam);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Manga $manga, Chapter $chapter, ChapterTeam $chapterTeam)
    {
        $this->authorize('delete', $chapterTeam);

        app(ChapterTeamService::class, [
            'chapterTeam' => $chapterTeam
        ])->delete();

        return response()->noContent();
    }
}
