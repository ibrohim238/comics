<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\TeamMemberDto;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\TeamMemberRequest;
use App\Versions\V1\Http\Resources\UserCollection;
use App\Versions\V1\Http\Resources\UserResource;
use App\Versions\V1\Services\TeamMemberService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Team $team, Request $request): UserCollection
    {
        $members = $team->users()->paginate($request->get('count'));

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
        ])->syncRoles(
            TeamMemberDto::fromArray($request)
        );

        return new UserResource($user);
    }
}
