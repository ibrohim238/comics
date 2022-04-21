<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Team\Team;
use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\InviteTeamMemberService;
use App\Versions\V1\Services\TeamMemberService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Request;

class TeamMemberController extends Controller
{
    public function store(Request $request, Team $team, User $user)
    {
        $this->authorize('addTeamInvite', $team);

        app(InviteTeamMemberService::class)->invite(
            $team,
            $user,
            $request->get('role')
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Team $team, User $user)
    {
        $this->authorize('updateTeamMember', $team);

        app(TeamMemberService::class)->update(
            $team,
            $user,
            $request->get('role')
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Team $team, User $user)
    {
        /*Исправить*/
        $this->authorize('removeTeamMember', $team);

        app(TeamMemberService::class)
            ->remove($team, $user);
    }
}
