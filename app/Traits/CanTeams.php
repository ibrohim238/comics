<?php

namespace App\Traits;

use App\Enums\TeamPermissionEnum;
use App\Enums\TeamRoleEnum;
use App\Interfaces\Teamable;
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
            ->withTimestamps()
            ->as('membership');
    }

    public function findTeam(Team $team)
    {
        return $this->teams()->where('team_id', $team->id)->first();
    }

    public function hasTeamable(Team $team,Teamable $teamable): bool
    {
        return $this->findTeam($team)->hasTeamable($teamable);
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    public function teamRole(Team $team)
    {
        return $this->findTeam($team)?->membership->role;
    }

    public function hasTeamRole(Team $team, string $role): bool
    {
        return $this->teamRole($team) == $role;
    }

    public function teamPermissions(Team $team): array
    {
        return TeamRoleEnum::tryFrom($this->teamRole($team))?->permissions() ?? [];
    }

    public function hasTeamPermission(Team $team, TeamPermissionEnum $permission): bool
    {
        return in_array($permission, $this->teamPermissions($team));
    }
}
