<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\TeamPermissionEnum;
use App\Models\Team;
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
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_TEAM->value)
            || $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }

    public function restore(User $user, Team $team): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_TEAM->value)
            || $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_TEAM->value);
    }


    public function forceDelete(User $user, Team $team): bool
    {
        return $user->hasPermissionTo(PermissionEnum::MANAGE_TEAM->value);
    }
}
