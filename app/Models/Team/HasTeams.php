<?php

namespace App\Models\Team;

use App\Enums\TeamRolePermissionEnum;
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

    public function ownsTeam(Team $team)
    {
        if (is_null($team)) {
            return false;
        }

        return $this->id == $team->{$this->getForeignKey()};
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    public function teamRole(Team $team): string|null
    {
        return $team->users()->findOrFail($this->user)->membership->role;
    }

    public function hasTeamRole(Team $team, string $role): bool
    {
        return $this->teamRole($team) ==  $role;
    }

    public function teamPermissions(Team $team): array
    {
        return TeamRolePermissionEnum::from($this->teamRole($team))->permissions() ;
    }

    public function hasTeamPermission(Team $team, string $permission): bool
    {
        return in_array($permission, $this->teamPermissions($team));
    }
}
