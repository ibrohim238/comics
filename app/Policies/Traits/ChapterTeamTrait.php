<?php

namespace App\Policies\Traits;

use App\Enums\TeamPermissionEnum;
use App\Models\Team;
use App\Models\User;

trait ChapterTeamTrait
{
    public function chapterViewAny(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function chapterView(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function chapterCreate(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function chapterUpdate(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function chapterDelete(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }
}
