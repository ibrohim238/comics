<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait TeamTrait
{
    public function team(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'team_users',
            'user_id',
            'team_id'
        );
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }
}
