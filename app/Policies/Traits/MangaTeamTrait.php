<?php

namespace App\Policies\Traits;

use App\Enums\TeamPermissionEnum;
use App\Models\Team;
use App\Models\User;

trait MangaTeamTrait
{
    public function mangaViewAny(?User $user): bool
    {
        return true;
    }

    public function mangaView(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }
}
