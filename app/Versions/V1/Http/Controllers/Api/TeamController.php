<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Versions\V1\Dto\TeamDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\TeamRequest;
use App\Versions\V1\Http\Resources\TeamCollection;
use App\Versions\V1\Http\Resources\TeamResource;
use App\Versions\V1\Services\TeamService;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Team::class);
    }

    public function index()
    {
        return new TeamCollection(
            Team::query()->get()
        );
    }

    public function show(Team $team)
    {
        return new TeamResource($team);
    }

    /**
     * @throws UnknownProperties
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(TeamRequest $request)
    {
        $team = app(TeamService::class, [new Team()])->create(TeamDto::fromRequest($request), Auth::user());

        return new TeamResource($team);
    }

    /**
     * @throws UnknownProperties
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function update(Team $team, TeamRequest $request)
    {
        app(TeamService::class, [$team])->update(TeamDto::fromRequest($request));

        return new TeamResource($team);
    }

    public function destroy(Team $team)
    {
        app(TeamService::class, [$team])->delete();

        return response()->noContent();
    }
}
