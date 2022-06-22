<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\TeamPermissionEnum;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use App\Policies\Traits\ChapterTeamTrait;
use App\Policies\Traits\MangaTeamTrait;
use App\Policies\Traits\TeamableTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;
    use ChapterTeamTrait;
    use MangaTeamTrait;
    use TeamableTrait;

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
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM);
    }

    public function sendTeamInvite(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM);
    }

    public function updateTeamMember(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM);
    }

    public function removeTeamMember(User $correctUser, User $user, Team $team): bool
    {
        return $correctUser->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM)
            || $correctUser->is($user);
    }

    public function addTeamMember(User $user, TeamInvitation $invitation): bool
    {
        return $user->id == $invitation->user_id;
    }

    public function deleteTeamInvite(User $user, TeamInvitation $invitation): bool
    {
        return $user->id == $invitation->user_id
            || $user->hasTeamPermission($invitation->team, TeamPermissionEnum::MANAGE_TEAM);
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->hasRole(PermissionEnum::MANAGE_TEAM->value)
            || $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM);
    }


    public function restore(User $user, Team $team): bool
    {
        return $user->hasRole(PermissionEnum::MANAGE_TEAM->value)
            || $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM);
    }

    public function forceDelete(User $user, Team $team)
    {
        //
    }
}
