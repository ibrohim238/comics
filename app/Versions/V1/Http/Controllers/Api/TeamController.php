<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\TeamRolePermissionEnum;
use App\Http\Requests\TeamRequest;
use App\Models\Team\Team;
use App\Versions\V1\Dto\TeamDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\TeamCollection;
use App\Versions\V1\Http\Resources\TeamResource;
use App\Versions\V1\Http\Resources\UserCollection;
use App\Versions\V1\Services\TeamMemberService;
use App\Versions\V1\Services\TeamService;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TeamController extends Controller
{
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
    public function store(TeamRequest $request, TeamService $service)
    {
        $team = $service->save(new Team(), TeamDto::fromRequest($request));
        app(TeamMemberService::class)
            ->add($team, Auth::user(), TeamRolePermissionEnum::owner->value);

        return new TeamResource($team);
    }

    /**
     * @throws UnknownProperties
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function update(Team $team, TeamRequest $request, TeamService $service)
    {
        $team = $service->save($team, TeamDto::fromRequest($request));

        return new TeamResource($team);
    }

    public function destroy(Team $team, TeamService $service)
    {
        $service->delete($team);

        return response()->noContent();
    }
}
