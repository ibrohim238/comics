<?php

namespace App\Models\Team;

use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, TeamUser::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    public function hasTeamPermission(User $user, string $permission): bool
    {
        return $user->hasTeamPermission($this, $permission);
    }

    public function teamInvitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function teamable(): MorphTo
    {
        return $this->morphTo();
    }
}
