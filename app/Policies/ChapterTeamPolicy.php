<?php

namespace App\Policies;

use App\Enums\TeamPermissionEnum;
use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Manga;
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

    public function create(User $user, Team $team): bool
    {
        return $user->hasTeamPermission($team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function update(User $user, Manga $manga, Chapter $chapter, ChapterTeam $chapterTeam): bool
    {
        return $user->hasTeamPermission($chapterTeam->team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function delete(User $user, Manga $manga, Chapter $chapter, ChapterTeam $chapterTeam): bool
    {
        return $user->hasTeamPermission($chapterTeam->team, TeamPermissionEnum::MANAGE_MANGA);
    }

    public function restore(User $user, Manga $manga): bool
    {
        //
    }

    public function forceDelete(User $user, Manga $manga): bool
    {
        //
    }
}
