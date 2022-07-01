<?php

namespace App\Models;

use App\Enums\TeamPermissionEnum;
use App\Interfaces\Invited;
use App\Interfaces\Teamable;
use App\Traits\HasInvitations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia, Invited
{
    use HasFactory;
    use InteractsWithMedia;
    use HasInvitations;

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

    public function hasPermission(User $user, TeamPermissionEnum $permission): bool
    {
        return $user->hasTeamPermission($this, $permission);
    }

    public function mangas(): MorphToMany
    {
        return $this->morphedByMany(Manga::class, 'teamable');
    }

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class, ChapterTeam::class)
            ->withPivot('free_at');
    }
}
