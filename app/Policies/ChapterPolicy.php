<?php

namespace App\Policies;

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
        if (! $chapter->is_paid) {
            return false;
        }
        return true;
    }

    public function create(User $user, Chapter $chapter, Team $team): bool
    {
        return $user->hasTeamable($team, $chapter->manga);
    }

    public function update(User $user, Chapter $chapter, Team $team): bool
    {
        return $user->hasTeamable($team, $chapter->manga);
    }

    public function delete(User $user, Chapter $chapter, Team $team): bool
    {
        return $user->hasTeamable($team, $chapter->manga);
    }

    public function restore(User $user, Chapter $chapter): bool
    {
        //
    }

    public function forceDelete(User $user, Chapter $chapter): bool
    {
        //
    }
}
