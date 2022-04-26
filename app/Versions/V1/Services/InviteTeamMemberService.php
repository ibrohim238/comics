<?php

namespace App\Versions\V1\Services;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;

class InviteTeamMemberService
{
    public function invite(Team $team, User $user, string $role)
    {
        $team->teamInvitations()->create([
            'user_id' => $user->id,
            'role' => $role
        ]);
    }

    public function delete(TeamInvitation $invitation)
    {
        $invitation->delete();
    }
}
