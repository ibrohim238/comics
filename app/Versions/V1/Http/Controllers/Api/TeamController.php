<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Versions\V1\Dto\TeamDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\TeamRequest;
use App\Versions\V1\Http\Resources\TeamCollection;
use App\Versions\V1\Http\Resources\TeamResource;
use App\Versions\V1\Repositories\TeamRepository;
use App\Versions\V1\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use function app;
use function response;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->authorizeResource(Team::class);
    }

    public function index(Request $request): TeamCollection
    {
        $teams = app(TeamRepository::class)
            ->paginate($request->get('count'));

        return new TeamCollection($teams);
    }

    public function show(Team $team): TeamResource
    {
        return new TeamResource($team);
    }

    /**
     * @throws UnknownProperties
     */
    public function store(TeamRequest $request): TeamResource
    {
        $team = app(TeamService::class)
            ->store(TeamDto::fromRequest($request));

        return new TeamResource($team);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(Team $team, TeamRequest $request): TeamResource
    {
        app(TeamService::class, [
            'team' => $team
        ])->update(TeamDto::fromRequest($request));

        return new TeamResource($team);
    }

    public function destroy(Team $team): Response
    {
        app(TeamService::class, [
            'team' => $team
        ])->delete();

        return response()->noContent();
    }
}
