<?php

namespace App\Models;

use App\Enums\TeamPermissionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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

    public function hasTeamPermission(User $user, TeamPermissionEnum $permission): bool
    {
        return $user->hasTeamPermission($this, $permission);
    }

    public function teamInvitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function mangas(): MorphToMany
    {
        return $this->morphedByMany(Manga::class, 'teamable');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }
}
