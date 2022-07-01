<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use App\Versions\V1\Dto\TeamMemberDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\TeamMemberRequest;
use App\Versions\V1\Http\Resources\InvitationResource;
use App\Versions\V1\Http\Resources\UserCollection;
use App\Versions\V1\Http\Resources\UserResource;
use App\Versions\V1\Services\UserInviteService;
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

    public function index(Team $team, Request $request)
    {
        $members = $team->users()->paginate($request->get('count'));

        return new UserCollection($members);
    }

    public function show(Team $team, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(TeamMemberRequest $request, Team $team, User $user)
    {
        $this->authorize('updateTeamMember', $team);

        app(TeamMemberService::class, [
            'team' => $team,
            'user' => $user,
        ])->update(
            TeamMemberDto::fromArray($request)
        );

        return response()->json([
           'message' => Lang::get('team-member.update'),
        ]);
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
        ])->remove();

        return response()->json([
            'message' => Lang::get('team-member.delete'),
        ]);
    }
}
