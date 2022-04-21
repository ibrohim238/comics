<?php

namespace App\Versions\V1\Services;

use App\Models\Team\Team;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class TeamMemberService
{
    public function add(Team $team, User $user, string $role): void
    {
        $team->users()->attach($user->id, ['role' => $role]);
    }

    public function update(Team $team, User $user, string $role): void
    {
        $team->users()->updateExistingPivot($user->id, ['role' => $role]);
    }

    public function  remove(Team $team, User $user): void
    {
        /*Исправить*/

        $team->users()->detach($user);
    }
}
