<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\TeamMemberRequest;
use App\Versions\V1\Services\InviteTeamMemberService;
use App\Versions\V1\Services\TeamMemberService;
use Illuminate\Auth\Access\AuthorizationException;

class TeamMemberController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(TeamMemberRequest $request, Team $team, User $user)
    {
        $this->authorize('addTeamInvite', $team);

        app(InviteTeamMemberService::class)->invite(
            $team,
            $user,
            $request->validated()
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function update(TeamMemberRequest $request, Team $team, User $user)
    {
        $this->authorize('updateTeamMember', [$user, $team]);

        app(TeamMemberService::class)->update(
            $team,
            $user,
            $request->validated()
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Team $team, User $user)
    {
        $this->authorize('removeTeamMember', $team);

        app(TeamMemberService::class)
            ->remove($team, $user);
    }
}
