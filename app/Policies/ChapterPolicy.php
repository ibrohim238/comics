<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\TeamPermissionEnum;
use App\Models\Chapter;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ChapterPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Chapter $chapter): bool
    {
        return Carbon::now() > $chapter->free_at
            || !is_null($user)
                &&( $chapter->team ? $user->hasTeamPermission($chapter->team, TeamPermissionEnum::MANAGE_MANGA->value) :
                    $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value)
                    || $user->access_chapter($chapter) );
    }

    public function create(User $user, ?int $teamId): bool
    {
        return $teamId ? $user->hasTeamPermission($teamId, TeamPermissionEnum::MANAGE_MANGA->value)
            : $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function update(User $user, Chapter $chapter): bool
    {
        return $chapter->team ? $user->hasTeamPermission($chapter->team, TeamPermissionEnum::MANAGE_MANGA->value)
            : $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }

    public function delete(User $user, Chapter $chapter): bool
    {
        return $chapter->team ? $user->hasTeamPermission($chapter->team, TeamPermissionEnum::MANAGE_MANGA->value)
            : $user->hasPermissionTo(PermissionEnum::MANAGE_MANGA->value);
    }
}
