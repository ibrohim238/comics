<?php

namespace App\Models;

use App\Enums\TeamPermissionEnum;
use App\Enums\TeamRoleEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTeams
{
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, TeamUser::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    public function team(Team $team): Team
    {
        return $this->teams()->where('id', $team->id)->first();
    }

    public function hasTeamable(Team $team,Teamable $teamable): bool
    {
        return $this->team($team)->hasTeamable($teamable);
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    public function teamRole(Team $team): string|null
    {
        return $team->users()->find($this->id)?->membership->role;
    }

    public function hasTeamRole(Team $team, string $role): bool
    {
        return $this->teamRole($team) == $role;
    }

    public function teamPermissions(Team $team): array
    {
        return TeamRoleEnum::from($this->teamRole($team))->permissions() ;
    }

    public function hasTeamPermission(Team $team, TeamPermissionEnum $permission): bool
    {
        return in_array($permission, $this->teamPermissions($team));
    }
}
