<?php

namespace App\Policies;

use App\Enums\TeamPermissionEnum;
use App\Models\Chapter;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Chapter $chapter): bool
    {
        return true;
    }

    public function create(User $user, int $teamId): bool
    {
        return $user->hasTeamPermission($teamId, TeamPermissionEnum::MANAGE_MANGA->value);
    }

    public function update(User $user, Chapter $chapter): bool
    {
        return $user->hasTeamPermission($chapter->team, TeamPermissionEnum::MANAGE_MANGA->value);
    }

    public function delete(User $user, Chapter $chapter): bool
    {
        return $user->hasTeamPermission($chapter->team, TeamPermissionEnum::MANAGE_MANGA->value);
    }
}
