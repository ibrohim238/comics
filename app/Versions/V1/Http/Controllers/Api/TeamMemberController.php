<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamMemberDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\TeamMemberRequest;
use App\Versions\V1\Http\Resources\UserCollection;
use App\Versions\V1\Http\Resources\UserResource;
use App\Versions\V1\Repositories\TeamRepository;
use App\Versions\V1\Services\TeamMemberService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use function app;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Team $team, Request $request): UserCollection
    {
        $members = app(TeamRepository::class, [
            'team' => $team
        ])->paginate($request->get('count'));

        return new UserCollection($members);
    }

    public function show(Team $team, User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(TeamMemberRequest $request, Team $team, User $user): UserResource
    {
        $this->authorize('updateTeamMember', $team);

        app(TeamMemberService::class, [
            'team' => $team,
            'user' => $user,
        ])->updateRole(TeamMemberDto::fromArray($request));

        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Team $team, User $user)
    {
        $this->authorize('removeTeamMember', $team);

        app(TeamMemberService::class, [
            'team' => $team,
            'user' => $user,
        ])->removeRole();
    }
}
