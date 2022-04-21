<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\TeamInvitation;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\InviteTeamMemberService;
use App\Versions\V1\Services\TeamMemberService;
use Illuminate\Auth\Access\AuthorizationException;

class TeamInvitationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function accept(TeamInvitation $invitation)
    {
        $this->authorize('addTeamMember', $invitation);

        app(TeamMemberService::class)->add(
            $invitation->team,
            $invitation->user,
            $invitation->role,
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(TeamInvitation $invitation)
    {
        $this->authorize('deleteTeamInvite', $invitation);

        app(InviteTeamMemberService::class)->delete($invitation);
    }
}
