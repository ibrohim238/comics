<?php

namespace App\Models;

use App\Interfaces\Invited;
use App\Traits\HasInvitations;
use IAleroy\Teams\Models\Team as BaseTeam;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Team extends BaseTeam implements Invited
{
    use HasInvitations;

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
