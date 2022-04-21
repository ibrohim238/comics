<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\TeamPermissionEnum;
use App\Models\Team\Team;
use App\Models\Team\TeamRole;
use App\Models\Team\TeamUser;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::CREATE_TEAM->value);
    }

    public function update(User $user, Team $team): bool
    {
        return
            $user->hasRole(PermissionEnum::MANAGE_TEAM->value)
            ||
            $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function sendTeamInvite(User $user, Team $team): bool
    {
        return
            $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function updateTeamMember(User $user, Team $team): bool
    {
        return
            $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function removeTeamMember(User $user, Team $team): bool
    {
        /* Исправить */
        return
            $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function addTeamMember(User $user, TeamInvitation $invitation): bool
    {
        return $user->id == $invitation->user_id;
    }

    public function deleteTeamInvite(User $user, TeamInvitation $invitation): bool
    {
        return
            $user->id == $invitation->user_id
            ||
            $user->hasTeamPermission($invitation->team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function delete(User $user, Team $team): bool
    {
        return
            $user->hasRole(PermissionEnum::MANAGE_TEAM->value)
            ||
            $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }


    public function restore(User $user, Team $team): bool
    {
        return
            $user->hasRole(PermissionEnum::MANAGE_TEAM->value)
            ||
            $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function forceDelete(User $user, Team $team)
    {
        //
    }
}
