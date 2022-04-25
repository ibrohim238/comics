<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\TeamableIndexRequest;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Services\TeamableService;
use App\Versions\V1\Traits\IdentifiesModels;
use Illuminate\Auth\Access\AuthorizationException;

class TeamableController extends Controller
{
    use IdentifiesModels;

    public function index(Team $team, TeamableIndexRequest $request): MangaCollection
    {
        $teamable = $team->teamable()
            ->where('teamable_type', $request->validated())
            ->get();

        return new MangaCollection($teamable);
    }

    public function show(Team $team, string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);

        return new MangaResource($model);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Team $team, string $model, int $id)
    {
        $this->authorize('addTeamable', $team);

        $model = $this->identifyModel($model, $id);

        app(TeamableService::class, [$model, $team])->create();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Team $team, string $model, int $id)
    {
        $this->authorize('addTeamable', $team);

        $model = $this->identifyModel($model, $id);

        app(TeamableService::class, [$model, $team]);
    }
}

