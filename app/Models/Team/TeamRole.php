<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamRole extends Model
{
    use HasFactory;

    protected $fillable = [
      'title'
    ];

    public function teamUser(): BelongsToMany
    {
        return $this->belongsToMany(
            TeamUser::class,
            'team_user_has_role',
            'team_role_id',
            'team_user_id'
        );
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            TeamPermission::class,
            'team_role_has_permissions',
            'team_role_id',
            'team_permission_id'
        );
    }
}
