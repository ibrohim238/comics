<?php

namespace App\Traits;

use App\Enums\TeamPermissionEnum;
use App\Enums\TeamRoleEnum;
use App\Interfaces\Teamable;
use App\Models\Manga;
use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanTeams
{
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, TeamUser::class)
            ->withPivot('role')
            ->as('membership');
    }

    public function hasTeamRole(Team $team, string $role): bool
    {
        return $this->teamRole($team) == $role;
    }

    public function hasTeamPermission(Team $team, TeamPermissionEnum $permission): bool
    {
        return in_array($permission->value, $this->teamPermissions($team));
    }

    public function findTeam(Team $team): ?Team
    {
        return $this->teams()->where('team_id', $team->id)->first();
    }

    private function teamRole(Team $team)
    {
        return $this->findTeam($team)?->membership->role;
    }

    public function teamPermissions(Team $team): array
    {
        return TeamRoleEnum::tryFrom($this->teamRole($team))?->permissions() ?? [];
    }
}
