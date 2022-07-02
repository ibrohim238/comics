<?php

namespace App\Policies;

use App\Enums\TeamPermissionEnum;
use App\Models\ChapterTeam;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterTeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, ChapterTeam $chapterTeam): bool
    {
        if ($chapterTeam->free_at >= Carbon::now()) {
            return false;
        }
        return true;
    }

    public function create(User $user, int $teamId): bool
    {
        return $user->hasTeamPermission(Team::find($teamId), TeamPermissionEnum::MANAGE_MANGA);
    }

    public function update(User $user, ChapterTeam $chapterTeam): bool
    {
        return $user->hasTeamPermission($chapterTeam->team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function delete(User $user, ChapterTeam $chapterTeam): bool
    {
        return $user->hasTeamPermission($chapterTeam->team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function restore(User $user, ChapterTeam $chapterTeam): bool
    {
        //
    }

    public function forceDelete(User $user, ChapterTeam $chapterTeam): bool
    {
        //
    }
}
