<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamPermission extends Model
{
    use HasFactory;

    protected $fillable = [
      'title'
    ];

    public function role(): BelongsToMany
    {
        return $this->belongsToMany(
            TeamRole::class,
            'team_role_has_permissions',
            'team_permission_id',
            'team_role_id'
        );
    }
}
